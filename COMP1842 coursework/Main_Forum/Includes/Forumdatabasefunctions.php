<?php
##REUSABLE QUERY FUNCTION##
function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

##topic FUNCTIONS##

function gettopic($pdo, $topicId) {
    $parameters = [':topicId' => $topicId];
    $query = query($pdo, 'SELECT * FROM topics WHERE topic_id = :topicId', $parameters);
    return $query->fetch();
}

function totaltopics($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM topics');
    $row = $query->fetch();
    return $row[0];
}

function alltopics($pdo) {
    $query = 'SELECT topic_id, title, created_at, user_id
    FROM topics';
    $topics = query($pdo, $query);
    return $topics->fetchAll();
}

function inserttopic($pdo, $title, $userId) {
    $query = 'INSERT INTO topics (title, created_at, user_id)
    VALUES (:title, NOW(), :userId)';
    $parameters = [':title' => $title, ':userId' => $userId];
    query($pdo, $query, $parameters);
}

function updatetopic($pdo, $topicId, $title) {
    $query = 'UPDATE topics SET title = :title WHERE topic_id = :topicId';
    $parameters = [':title' => $title, ':topicId' => $topicId];
    query($pdo, $query, $parameters);
}

function deletetopic($pdo, $topicId) {
    $parameters = [':topicId' => $topicId];
    query($pdo, 'DELETE FROM topics WHERE topic_id = :topicId', $parameters);
}

##POST FUNCTIONS##

function allPosts($pdo) {
    $query = 'SELECT p.post_id, p.title, p.created_at, p.user_id, p.topic_id, u.username, t.title as topic_title
    FROM posts p
    LEFT JOIN users u ON p.user_id = u.user_id
    LEFT JOIN topics t ON p.topic_id = t.topic_id';
    $posts = query($pdo, $query);
    return $posts->fetchAll();
}
function getPost($pdo, $postId) {
    $query = 'SELECT * FROM posts WHERE post_id = :postId';
    $parameters = [':postId' => $postId];
    $result = query($pdo, $query, $parameters);
    return $result->fetch();
}

function insertpost($pdo, $title, $content, $topicId, $userId) {
    $query = 'INSERT INTO posts (title, content, created_at, topic_id, user_id)
    VALUES (:title, :content, NOW(), :topicId, :userId)';
    $parameters = [':title' => $title, ':content' => $content, ':topicId' => $topicId, ':userId' => $userId];
    query($pdo, $query, $parameters);
}

function updatepost($pdo, $postId, $title, $content, $topicId) {
    $query = 'UPDATE posts SET title = :title, content = :content, topic_id = :topicId WHERE post_id = :postId';
    $parameters = [':title' => $title, ':content' => $content, ':topicId' => $topicId, ':postId' => $postId];
    query($pdo, $query, $parameters);
}

function deletePost($pdo, $postId) {
    // Delete replies
    $parameters = [':postId' => $postId];
    query($pdo, 'DELETE FROM replies WHERE post_id = :postId', $parameters);

    // Delete post
    $parameters = [':postId' => $postId];
    query($pdo, 'DELETE FROM posts WHERE post_id = :postId', $parameters);
}
##REPLY FUNCTIONS##

function allReplies($pdo, $postId) {
    $replies = query($pdo, 'SELECT * FROM replies WHERE post_id = ?', [$postId]);
    return $replies->fetchAll();
}

function getReply($pdo, $replyId) {
    $parameters = [':replyId' => $replyId];
    $query = query($pdo, 'SELECT * FROM replies WHERE reply_id = :replyId', $parameters);
    return $query->fetch();
}

function insertReply($pdo, $content, $postId, $userId) {
    $query = 'INSERT INTO replies (content, created_at, post_id, user_id)
    VALUES (:content, NOW(), :postId, :userId)';
    $parameters = [':content' => $content, ':postId' => $postId, ':userId' => $userId];
    query($pdo, $query, $parameters);
}

function updateReply($pdo, $replyId, $content) {
    $query = 'UPDATE replies SET content = :content WHERE reply_id = :replyId';
    $parameters = [':content' => $content, ':replyId' => $replyId];
    query($pdo, $query, $parameters);
}

function deleteReply($pdo, $replyId) {
    $parameters = [':replyId' => $replyId];
    query($pdo, 'DELETE FROM replies WHERE reply_id = :replyId', $parameters);
}

##USER FUNCTIONS##

function allUsers($pdo) {
    $users = query($pdo, 'SELECT * FROM users');
    return $users->fetchAll();
}

function getUser($pdo, $username) {
  $parameters = [':username' => $username];
  $query = query($pdo, 'SELECT * FROM users WHERE username = :username', $parameters);
  return $query->fetch();
}

// Main_Forum/Includes/Forumdatabasefunctions.php
function getPostIdFromReplyId($pdo, $replyId) {
    $query = 'SELECT post_id FROM replies WHERE reply_id = :replyId';
    $parameters = [':replyId' => $replyId];
    $stmt = query($pdo, $query, $parameters);
    $result = $stmt->fetch();
    return $result['post_id'];
}
## Admin Contacts FUNCTIONS ##

function getAdminContact($pdo, $contactId) {
    $parameters = [':contactId' => $contactId];
    $query = query($pdo, 'SELECT * FROM admin_contacts WHERE contact_id = :contactId', $parameters);
    return $query->fetch();
}

function getAllAdminContacts($pdo) {
    $query = 'SELECT * FROM admin_contacts';
    $contacts = query($pdo, $query);
    return $contacts->fetchAll();
}

function insertAdminContact($pdo, $userId, $message, $adminId) {
  $query = 'INSERT IGNORE INTO admin_contacts (user_id, message, admin_id) VALUES (:userId, :message, :adminId)';
  $parameters = [':userId' => $userId, ':message' => $message, ':adminId' => $adminId];
  query($pdo, $query, $parameters);
}
function updateAdminContact($pdo, $contactId, $message) {
    $query = 'UPDATE admin_contacts SET message = :message WHERE contact_id = :contactId';
    $parameters = [':message' => $message, ':contactId' => $contactId];
    query($pdo, $query, $parameters);
}

function deleteAdminContact($pdo, $contactId) {
    $parameters = [':contactId' => $contactId];
    query($pdo, 'DELETE FROM admin_contacts WHERE contact_id = :contactId', $parameters);
}
function getUserId($pdo, $username) {
    $parameters = [':username' => $username];
    $query = query($pdo, 'SELECT user_id FROM users WHERE username = :username', $parameters);
    $row = $query->fetch();
    return $row['user_id'];
}
