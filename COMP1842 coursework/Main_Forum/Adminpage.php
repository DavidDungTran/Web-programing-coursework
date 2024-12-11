<?php
    //start PHP session
    session_start();
  
    //check if admin is logged in
    if(!isset($_SESSION['admin'])){
        //redirect to login page
        header('Location: admin_login.php');
        exit;
    }
  
    //include our database connection
    include 'Includes/Databaseconnection.php';
    include 'Includes/Forumdatabasefunctions.php';
  
    //get the messages from the Admin_contact table
    $stmt = $pdo->prepare('SELECT * FROM admin_contacts');
    $stmt->execute();
    $messages = $stmt->fetchAll();
?>
  
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <h2>Messages from Users:</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>User Email</th>
            <th>Message</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
        <?php foreach($messages as $message): ?>
            <tr>
                <td><?php echo $message['user_id']; ?></td>
                <td><?php echo 'No Email'; ?></td>
                <td><?php echo $message['message']; ?></td>
                <td><a href="admin_delete.php?contactId=<?php echo $message['contact_id']; ?>">Delete</a></td>
                <td><a href="admin_edit.php?contactId=<?php echo $message['contact_id']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2>Manage Users:</h2>
    <a href="admin_users.php">View Users</a>
    <a href="admin_add_user.php">Add User</a>
    <h2>Manage Topics:</h2>
    <a href="admin_topics.php">View Topics</a>
    <a href="admin_add_topic.php">Add Topic</a>
    <h2>Manage Posts:</h2>
    <a href="admin_posts.php">View Posts</a>
    <a href="admin_add_post.php">Add Post</a>
    <h2>Manage Replies:</h2>
    <a href="admin_replies.php">View Replies</a>
    <a href="admin_add_reply.php">Add Reply</a>
    <h2>Manage Admin Contacts:</h2>
    <a href="admin_contacts.php">View Contacts</a>
    <a href="admin_add_contact.php">Add Contact</a>
    <button onclick="location.href='admin_logout.php'">Log Out</button>
</body>
</html>