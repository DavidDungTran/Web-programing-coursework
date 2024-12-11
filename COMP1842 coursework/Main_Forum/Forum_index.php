<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcomed to Neerpeerhelp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body {
        background-color: #4567b7;
      }
      .container {
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .post-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .post-card h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
      }
      .post-card p {
        font-size: 16px;
        margin-bottom: 10px;
      }
      .btn-blue-sky {
        background-color: #4567b7;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
      }
      .btn-blue-sky:hover {
        background-color: #337ab7;
      }
    </style>
  </head>
  <body>
    <h1 class="text-center mt-5">Welcomed to Neerpeerhelp</h1>
    <?php
      include 'includes/Databaseconnection.php';
      include 'includes/ForumDataBaseFunctions.php';

      $posts = allPosts($pdo);
    ?>
    <div class="container mt-5">
      <h2 class="mb-3">Latest Posts</h2>
      <div class="d-flex justify-content-between mb-3">
        <button class="btn-blue-sky" onclick="location.href='Posts/Addpost.php'">Create a Post</button>
        <button class="btn-blue-sky" onclick="location.href='Posts/Topics.php'">Topics</button>
        <button class="btn-blue-sky" onclick="location.href='Admincontact.php'">Contact Admin</button>
        <button class="btn-blue-sky" id="account-btn" style="position: absolute; top: 10px; right: 10px;">Account Details</button>
      </div>
      <div id="account-form" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
  <h2>Account Details</h2>
  <form>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>">
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>">
    <br>
    <button id="save-btn">Save Account</button>
    <button id="logout-btn">Log Out</button>
    <button id="delete-btn">Delete Account</button>
  </form>
</div>
      <?php foreach ($posts as $post) { ?>
        <div class="post-card">
          <h2><a href="Posts/Post.php?id=<?php echo $post['post_id']; ?>"><?php echo $post['title']; ?></a></h2>
          <p>Topic: <?php echo gettopic($pdo, $post['topic_id'])['title']; ?></p>
          <p>Username: <?php echo $post['username']; ?></p>
          <p>Date posted: <?php echo $post['created_at']; ?></p>
        </div>
      <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      document.getElementById("account-btn").addEventListener("click", function() {
        document.getElementById("account-form").style.display = "block";
      });
      
      document.getElementById("save-btn").addEventListener("click", function() {
        // Update the account details in the database
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        // Use AJAX to send a request to the server to update the account details
        // ...
        document.getElementById("account-form").style.display = "none";
      });
      
      document.getElementById("logout-btn").addEventListener("click", function() {
        // Log out the user and redirect to the login page
        // Use AJAX to send a request to the server to log out the user
        // ...
        window.location.href = "../loginpage/login_index.php";
      });
      
      document.getElementById("delete-btn").addEventListener("click", function() {
        // Delete the account and redirect to the login page
        // Use AJAX to send a request to the server to delete the account
        // ...
        window.location.href = "../loginpage/login_index.php";
      });
    </script>
  </body>
</html>