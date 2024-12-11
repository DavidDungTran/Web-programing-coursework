<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Topic Edit</title>
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
      .topic-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .topic-card h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
      }
      .topic-card p {
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
    <?php
      session_start(); // start the session
      include '../includes/Databaseconnection.php';
      include '../includes/ForumDataBaseFunctions.php';

      $topic_id = $_GET['topic_id'];
      $topic = getTopic($pdo, $topic_id);
    ?>
    <h1 class="text-center mt-5">Topic Edit</h1>
    <div class="container mt-5">
      <div class="topic-card">
        <h2><?php echo $topic['title']; ?></h2>
        <p>Created by: <?php echo isset($topic['username']) ? $topic['username'] : 'Unknown'; ?></p>
        <p>Created on: <?php echo $topic['created_at']; ?></p>
        <form action="" method="post">
          <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
          <input type="text" name="title" value="<?php echo $topic['title']; ?>">
          <button type="submit" class="btn-blue-sky" name="edit_topic">Edit Topic</button>
        </form>
        <form action="" method="post">
          <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
          <button type="submit" class="btn-blue-sky" name="delete_topic">Delete Topic</button>
        </form>
      </div>
    </div>
   <?php
     if (isset($_POST['edit_topic'])) {
       $topic_id = $_POST['topic_id'];
       $title = $_POST['title'];
       updateTopic($pdo, $topic_id, $title);
       echo "Topic updated successfully!";
     } elseif (isset($_POST['delete_topic'])) {
       $topic_id = $_POST['topic_id'];
       deleteTopic($pdo, $topic_id);
       echo "Topic deleted successfully!";
     }
     ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>