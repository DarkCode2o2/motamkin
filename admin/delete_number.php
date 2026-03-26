<?php 
    session_start();
    include_once '../config/helpers.php'; 
    $id = htmlspecialchars($_GET['id']);
    
    $stmt = $con->prepare("DELETE FROM numbers WHERE id = ? AND user_id = ?");
    try {
        $stmt->execute([$id, $_SESSION['user_id']]); 
        header("location: ../admin/numbers.php");
        exit;
      } catch(PDOException $e) {
          echo $e->getMessage();
      }

?>

