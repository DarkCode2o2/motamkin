<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . "/connect.php";




function getData($table, $column = null, $value = null, $filters = null, $all = false) {
    global $con;


    $allowedTables = ['users', 'numbers', 'reviews']; // whitelist tables
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


function isCurrentUrl(string $pagename, $returnBool = false) {

    $url = explode('/', trim($_SERVER['REQUEST_URI']));
    
    $name = explode('.', $url[1]);

    $current_url = $name[0] . '.php';

    if($returnBool) {
        return isset($current_url) && $current_url == $pagename ? true : false;
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


function checkToken() {
    global $con; 

    if(!isset($_COOKIE['remember_token'])) return false;

    $hashed_token = hash('sha256', $_COOKIE['remember_token']);

    $stmt = $con->prepare("SELECT * FROM users WHERE remember_token = ? LIMIT 1");
    $stmt->execute([$hashed_token]);
    $user = $stmt->fetch();
    return $user;
}


function getCount(string $table, $user_id) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $count = $stmt->fetchColumn();

    return $count;
}


function isExists($value, $table = 'users', $column = 'username') {
    global $con;
    $stmt = $con->prepare("SELECT id FROM $table where $column = ? LIMIT 1");
    $stmt->execute([$value]);

    return $stmt->fetch();
} 

/**
 * Helper function to display star rating
 * @param int $rating Rating value (1-5)
 * @param bool $echo Whether to echo or return
 * @return string HTML stars
 */
function displayStars($rating, $echo = true) {
    $rate = intval($rating);
    $stars = '';
    if($rate < 5) {
        $stars .= str_repeat('<span class="star empty">★</span>', 5 - $rate);
        $stars .= str_repeat('<span class="star">★</span>', $rate);
    }else {
        $stars .= str_repeat('<span class="star">★</span>', $rate);

    }

    return $stars;
}

/**
 * Get all approved reviews
 * @return array Array of approved reviews
 */
function getApprovedReviews() {
    global $con;
    $stmt = $con->prepare("SELECT * FROM reviews WHERE status = 1 ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get review count by status
 * @param int|null $status Status filter (0 or 1), null for all
 * @return int Count of reviews
 */
function getReviewCount($status = null) {
    global $con;
    
    if ($status !== null) {
        $stmt = $con->prepare("SELECT COUNT(*) FROM reviews WHERE status = ?");
        $stmt->execute([$status]);
    } else {
        $stmt = $con->prepare("SELECT COUNT(*) FROM reviews");
        $stmt->execute();
    }
    
    return $stmt->fetchColumn();
}