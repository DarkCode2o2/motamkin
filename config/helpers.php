<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . "/connect.php";




function getData($table, $column = null, $value = null, $filters = null, $all = false) {
    global $con;


    $allowedTables = ['users', 'numbers']; // whitelist tables
    if (!in_array($table, $allowedTables)) {
        return false;
    }

    if($column) {
        $stmt = $con->prepare("SELECT * FROM $table WHERE $column = ? $filters");        
        $stmt->execute([$value]);
        if($all) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else {

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }else {
        $stmt = $con->prepare("SELECT * FROM $table $filters");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $data;
}

function user_numbers($column = null, $value = null, $user_id = null, $filter = null) {
    global $con;
    $stmt = $con->prepare("SELECT * FROM numbers WHERE $column = ? AND user_id = ? $filter");
    $stmt->execute([$value, $user_id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}


function isCurrentUrl(string $pagename) {

    $url = explode('/', trim($_SERVER['REQUEST_URI']));

    foreach($url as $url) {
        if($url == '' || $url == '/') {
            continue;
        }

        $current_url = $url;
    }


    return isset($current_url) && $current_url == $pagename ? 'active' : '';
}

function categoryNameToNumber(string $catName, $arabicName = false) {

    if($arabicName) {
        $categoriesAr = [
            'economic' => 'الإقتصادية',
            'special' => 'المميزة',
            'elite' => 'النخبة',
            'vip' => 'VIP',
            'bundle' => 'الطقم',
        ];
        return $categoriesAr[strtolower($catName)];
    }

    $categories = [
        'economic' => 1,
        'special' => 2,
        'elite' => 3,
        'vip' => 4,
        'bundle' => 5,
    ];
    return $categories[strtolower($catName)];
}


function getCount(string $table, $user_id) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $count = $stmt->fetchColumn();

    return $count;
}


function isExists(string $value) {
    global $con;
    $stmt = $con->prepare("SELECT id FROM users where username = ? LIMIT 1");
    $stmt->execute([$value]);

    return $stmt->fetch();
} 