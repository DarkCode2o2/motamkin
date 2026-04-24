<?php

// header('Content-Type: application/json; charset=utf-8');
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type, Authorization');

// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit;
// }

// require_once '../connect.php';

// // Get request method and data
// $method = $_SERVER['REQUEST_METHOD'];
// $input = json_decode(file_get_contents('php://input'), true);

// // Route handler
// try {
//     switch ($method) {
//         case 'GET':
//             handleGet($con, $_GET);
//             break;
//         case 'POST':
//             handlePost($con, $input);
//             break;
//         case 'PUT':
//             handlePut($con, $input);
//             break;
//         case 'DELETE':
//             handleDelete($con, $input);
//             break;
//         default:
//             http_response_code(405);
//             echo json_encode(['success' => false, 'message' => 'Method not allowed']);
//     }
// } catch (Exception $e) {
//     http_response_code(500);
//     echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
// }

// /**
//  * Handle GET requests - Fetch reviews
//  */
// function handleGet($con, $params) {
//     $id = isset($params['id']) ? intval($params['id']) : null;
//     $status = isset($params['status']) ? intval($params['status']) : 1; // Default to approved only
    
//     if ($id) {
//         // Get single review by ID
//         $stmt = $con->prepare("SELECT * FROM reviews WHERE id = ?");
//         $stmt->execute([$id]);
//         $review = $stmt->fetch(PDO::FETCH_ASSOC);
        
//         if ($review) {
//             echo json_encode(['success' => true, 'data' => $review]);
//         } else {
//             http_response_code(404);
//             echo json_encode(['success' => false, 'message' => 'Review not found']);
//         }
//     } else {
//         // Get all reviews with optional status filter
//         if ($status !== null) {
//             $stmt = $con->prepare("SELECT * FROM reviews WHERE status = ? ORDER BY created_at DESC");
//             $stmt->execute([$status]);
//         } else {
//             $stmt = $con->prepare("SELECT * FROM reviews ORDER BY created_at DESC");
//             $stmt->execute();
//         }
        
//         $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         echo json_encode(['success' => true, 'data' => $reviews, 'count' => count($reviews)]);
//     }
// }

// /**
//  * Handle POST requests - Create new review
//  */
// function handlePost($con, $data) {
//     // Validate required fields
//     if (empty($data['name']) || empty($data['content']) || !isset($data['rating'])) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'الإسم، والحقل، والتقييم إجباري']);
//         return;
//     }
    
//     $name = trim(htmlspecialchars($data['name']));
//     $content = trim(htmlspecialchars($data['content']));
//     $rating = intval($data['rating']);
    
//     // Validate rating
//     if ($rating < 1 || $rating > 5) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'التقيم يجب ان يكون بين 5 - 1']);
//         return;
//     }
    
//     // Validate name length
//     if (strlen($name) < 20) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'جرب اسما أقصر']);
//         return;
//     }
    
//     // Validate content length
//     if (strlen($content) < 100) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'جرب تعليقا أقصر']);
//         return;
//     }
    
//     // Insert review with status = 0 (pending)
//     $stmt = $con->prepare("INSERT INTO reviews (name, content, rating, status) VALUES (?, ?, ?, 0)");
    
//     try {
//         $stmt->execute([$name, html_entity_decode($content), $rating]);
//         $reviewId = $con->lastInsertId();
        
//         echo json_encode([
//             'success' => true, 
//             'message' => 'تم إرسال التقييم بنجاح، سيتم عرضه بعد الإعتماد من قبل الأدمن.',
//             'data' => [
//                 'id' => $reviewId,
//                 'name' => $name,
//                 'rating' => $rating
//             ]
//         ]);
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['success' => false, 'message' => 'Failed to submit review']);
//     }
// }

// /**
//  * Handle PUT requests - Update review (Admin only)
//  */
// function handlePut($con, $data) {
//     // Verify admin authentication
//     if (!isset($_COOKIE['remember_token'])) {
//         http_response_code(401);
//         echo json_encode(['success' => false, 'message' => 'Authentication required']);
//         return;
//     }
    
//     // Verify admin role
//     $hashed_token = hash('sha256', $_COOKIE['remember_token']);
//     $stmt = $con->prepare("SELECT role FROM users WHERE remember_token = ? LIMIT 1");
//     $stmt->execute([$hashed_token]);
//     $user = $stmt->fetch();
    
//     if (!$user || $user['role'] != 0) {
//         http_response_code(403);
//         echo json_encode(['success' => false, 'message' => 'Admin access required']);
//         return;
//     }
    
//     // Validate required fields
//     if (empty($data['id'])) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'Review ID is required']);
//         return;
//     }
    
//     $id = intval($data['id']);
    
//     // Build update query dynamically
//     $updates = [];
//     $params = [];
    
//     if (isset($data['name'])) {
//         $updates[] = "name = ?";
//         $params[] = trim(htmlspecialchars($data['name']));
//     }
    
//     if (isset($data['content'])) {
//         $updates[] = "content = ?";
//         $params[] = trim(htmlspecialchars($data['content']));
//     }
    
//     if (isset($data['rating'])) {
//         $rating = intval($data['rating']);
//         if ($rating < 1 || $rating > 5) {
//             http_response_code(400);
//             echo json_encode(['success' => false, 'message' => 'التقيم يجب ان يكون بين 5 - 1']);
//             return;
//         }
//         $updates[] = "rating = ?";
//         $params[] = $rating;
//     }
    
//     if (isset($data['status'])) {
//         $status = intval($data['status']);
//         if (!in_array($status, [0, 1])) {
//             http_response_code(400);
//             echo json_encode(['success' => false, 'message' => 'الحالة يجب ان تكون واحد او صفر']);
//             return;
//         }
//         $updates[] = "status = ?";
//         $params[] = $status;
//     }
    
//     if (empty($updates)) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'لا توجد حقول لتحديثها']);
//         return;
//     }
    
//     $params[] = $id;
//     $query = "UPDATE reviews SET " . implode(", ", $updates) . " WHERE id = ?";
    
//     $stmt = $con->prepare($query);
    
//     try {
//         $stmt->execute($params);
        
//         if ($stmt->rowCount() > 0 || $con->query("SELECT 1 FROM reviews WHERE id = $id")->fetch()) {
//             echo json_encode(['success' => true, 'message' => 'Review updated successfully']);
//         } else {
//             http_response_code(404);
//             echo json_encode(['success' => false, 'message' => 'Review not found']);
//         }
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['success' => false, 'message' => 'Failed to update review']);
//     }
// }

// /**
//  * Handle DELETE requests - Remove review (Admin only)
//  */
// function handleDelete($con, $data) {
//     // Verify admin authentication
//     if (!isset($_COOKIE['remember_token'])) {
//         http_response_code(401);
//         echo json_encode(['success' => false, 'message' => 'Authentication required']);
//         return;
//     }
    
//     // Verify admin role
//     $hashed_token = hash('sha256', $_COOKIE['remember_token']);
//     $stmt = $con->prepare("SELECT role FROM users WHERE remember_token = ? LIMIT 1");
//     $stmt->execute([$hashed_token]);
//     $user = $stmt->fetch();
    
//     if (!$user || $user['role'] != 0) {
//         http_response_code(403);
//         echo json_encode(['success' => false, 'message' => 'Admin access required']);
//         return;
//     }
    
//     // Validate ID
//     if (empty($data['id'])) {
//         http_response_code(400);
//         echo json_encode(['success' => false, 'message' => 'Review ID is required']);
//         return;
//     }
    
//     $id = intval($data['id']);
    
//     $stmt = $con->prepare("DELETE FROM reviews WHERE id = ?");
    
//     try {
//         $stmt->execute([$id]);
        
//         if ($stmt->rowCount() > 0) {
//             echo json_encode(['success' => true, 'message' => 'تم حذف التقييم بنجاح']);
//         } else {
//             http_response_code(404);
//             echo json_encode(['success' => false, 'message' => 'Review not found']);
//         }
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['success' => false, 'message' => 'Failed to delete review']);
//     }
// }
?>
