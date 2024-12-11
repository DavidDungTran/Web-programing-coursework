<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Post</title>
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
      .btn-blue-sky {
        background-color: #337ab7;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
      }
      .btn-blue-sky:hover {
        background-color: #23527c;
      }
    </style>
  </head>
  <body>
    <h1 class="text-center mt-5">Edit Post</h1>
    <?php
      include '../includes/Databaseconnection.php';
      include '../includes/ForumDataBaseFunctions.php';

      if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $post = getPost($pdo, $postId);
        if ($post) {
    ?>
    <div class="container mt-5">
      <form action="edit_post.php?id=<?php echo $postId; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $postId; ?>">
        <div class="mb-3">
          <label for="title" class="form-label">Title:</label>
          <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title']; ?>">
        </div>
        <div class="mb-3">
          <label for="content" class="form-label">Content:</label>
          <textarea class="form-control" id="content" name="content"><?php echo $post['content']; ?></textarea>
        </div>
        <div class="mb-3">
          <label for="topic" class="form-label">Topic:</label>
          <select class="form-select" id="topic" name="topic">
            <?php
              $topics = alltopics($pdo);
              foreach ($topics as $topic) {
            ?>
            <option value="<?php echo $topic['topic_id']; ?>" <?php if ($topic['topic_id'] == $post['topic_id']) { echo 'selected'; } ?>><?php echo $topic['title']; ?></option>
            <?php
              }
            ?>
          </select>
        </div>
        <button type="submit" class="btn-blue-sky">Save Changes</button>
      </form>
    </div>
    <?php
        } else {
          echo 'Post not found';
        }
      } else {
        echo 'No post ID specified';
      }
    ?>
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postId = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $topicId = $_POST['topic'];

        updatepost($pdo, $postId, $title, $content, $topicId);

        header('Location: post.php?id=' . $postId);
        exit;
      }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>