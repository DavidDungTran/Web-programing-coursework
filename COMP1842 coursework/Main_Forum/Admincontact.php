<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Contact</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container" style="background-color: #f0f0f0; padding: 20px; margin-top: 20px; width: 50%;">

    <h2>Contact Admin</h2>

    <form action="" method="post">
      <div class="form-group">
        <label for="username">Username/Email:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary" name="send">Send</button>
    </form>

    <?php
    if (isset($_POST['send'])) {
      include 'Includes/Forumdatabasefunctions.php';
      include 'Includes/databaseconnection.php';
    
      $username = $_POST['username'];
      $message = $_POST['message'];
    
      $user = getUser($pdo, $username);
      if ($user === false) {
        echo '<div class="alert alert-danger">Error: User not found.</div>';
      } else {
        $userId = $user['user_id'];
        echo "User ID: $userId\n";
        echo "Message: $message\n";
        insertAdminContact($pdo, $userId, $message, 1); // assuming admin_id is 1
        echo '<div class="alert alert-success">Message sent successfully!</div>';
      }
    }
    ?>
  </div>
</body>
</html>