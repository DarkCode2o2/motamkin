<?php 
    session_start();
    
    if($_SESSION['role'] == 0) {
        include_once '../config/helpers.php'; 
        $id = htmlspecialchars($_GET['id']);
    
        $stmt = $con->prepare("DELETE FROM numbers WHERE id = ?");
        try {
            $stmt->execute([$id]); 
            header("location: ../admin/numbers.php");
            exit;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>

