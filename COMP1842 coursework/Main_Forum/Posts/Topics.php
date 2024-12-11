<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Topics</title>
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

      $topics = allTopics($pdo);
    ?>
    <h1 class="text-center mt-5">Topics</h1>
    <div class="container mt-5">
      <h2 class="mb-3">All Topics</h2>
      <div class="d-flex justify-content-between mb-3">
        <button class="btn-blue-sky" onclick="location.href='Posts/Addpost.php'">Create a Post</button>
        <button class="btn-blue-sky" data-bs-toggle="modal" data-bs-target="#addTopicModal">Add a Topic</button>
        <button class="btn-blue-sky" onclick="location.href='../Forum_index.php'">Back to Forum Index</button>
      </div>
      <?php foreach ($topics as $topic) { ?>
          <div class="topic-card">
              <h2><a href="Topic_edit.php?topic_id=<?php echo $topic['topic_id']; ?>"><?php echo $topic['title']; ?></a></h2>
              <p>Created by: <?php echo isset($topic['username']) ? $topic['username'] : 'Unknown'; ?></p>
              <p>Created on: <?php echo $topic['created_at']; ?></p>
          </div>
      <?php } ?>
    </div>

    <!-- Add Topic Modal -->
    <div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addTopicModalLabel">Add a Topic</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <div class="mb-3">
                <label for="topicName" class="form-label">Topic Name:</label>
                <input type="text" class="form-control" id="topicName" name="topicName">
              </div>
              <button type="submit" class="btn-blue-sky" name="addTopic">Add Topic</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
    if (isset($_POST['addTopic'])) {
        $topicName = $_POST['topicName'];
        $userId = $_SESSION['user_id'] ?? 'unknown';
        if ($userId == 'unknown') {
            $userId = null;
        }
        // Add topic to database
        inserttopic($pdo, $topicName, $userId);
        echo "Topic added successfully!";
    } else {
        // error handling
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>