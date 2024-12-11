<?php
session_start(); // Start the session
include '../includes/Databaseconnection.php';
include '../includes/ForumDataBaseFunctions.php';

if (isset($_POST['content']) && !empty($_POST['content'])) {
    $content = $_POST['content'];
    $postId = $_POST['post_id'];

    // Check if the user ID is provided
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Check if the user ID exists in the users table
        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // If the user ID exists, insert the reply
            $sql = "INSERT INTO replies (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':post_id', $postId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':content', $content);

            if ($stmt->execute()) {
                echo "Reply added successfully";
            } else {
                echo "Error adding reply: " . $pdo->errorInfo()[2];
            }
        } else {
            // If the user ID doesn't exist, insert the reply with a null user ID
            $sql = "INSERT INTO replies (post_id, content) VALUES (:post_id, :content)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':post_id', $postId);
            $stmt->bindParam(':content', $content);

            if ($stmt->execute()) {
                echo "Reply added successfully";
            } else {
                echo "Error adding reply: " . $pdo->errorInfo()[2];
            }
        }
    } else {
        // If the user ID is not provided, insert the reply with a null user ID
        $sql = "INSERT INTO replies (post_id, content) VALUES (:post_id, :content)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId);
        $stmt->bindParam(':content', $content);

        if ($stmt->execute()) {
            echo "Reply added successfully";
        } else {
            echo "Error adding reply: " . $pdo->errorInfo()[2];
        }
    }
} else {
    echo "Please enter a reply before submitting.";
}
?>