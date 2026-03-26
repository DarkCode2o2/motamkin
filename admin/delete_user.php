<?php 
    session_start();
    include_once '../config/helpers.php'; 
    $id = htmlspecialchars($_GET['id']);
    
    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    try {
        $stmt->execute([$id]); 
        header("location: ../admin/users.php");
        exit;
      } catch(PDOException $e) {
          echo $e->getMessage();
      }

?>

