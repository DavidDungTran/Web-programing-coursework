<?php
include '../includes/Databaseconnection.php';
include '../includes/ForumDataBaseFunctions.php';

if (isset($_POST['reply_id'])) {
    $replyId = $_POST['reply_id'];
    deletereply($pdo, $replyId);
    echo "Reply deleted successfully";
} else {
    echo "Error deleting reply";
}
?>