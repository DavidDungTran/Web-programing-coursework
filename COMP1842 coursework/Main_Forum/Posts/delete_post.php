<?php
include '../includes/Databaseconnection.php';
include '../includes/ForumDataBaseFunctions.php';

if (isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    deletePost($pdo, $postId);
    echo "Post deleted successfully";
} else {
    echo "Error deleting post";
}
?>