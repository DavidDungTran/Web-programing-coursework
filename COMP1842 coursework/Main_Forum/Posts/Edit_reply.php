<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Reply</title>
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
    <h1 class="text-center mt-5">Edit Reply</h1>
    <?php
      include '../includes/Databaseconnection.php';
      include '../includes/ForumDataBaseFunctions.php';

      if (isset($_GET['id'])) {
        $replyId = $_GET['id'];
        $reply = getReply($pdo, $replyId);
        if ($reply) {
    ?>
    <div class="container mt-5">
      <form action="edit_reply.php?id=<?php echo $replyId; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $replyId; ?>">
        <div class="mb-3">
          <label for="content" class="form-label">Content:</label>
          <textarea class="form-control" id="content" name="content"><?php echo $reply['content']; ?></textarea>
        </div>
        <button type="submit" class="btn-blue-sky">Save Changes</button>
      </form>
    </div>
    <?php
        } else {
          echo 'Reply not found';
        }
      } else {
        echo 'No reply ID specified';
      }
    ?>
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $replyId = $_POST['id'];
        $content = $_POST['content'];

        updateReply($pdo, $replyId, $content);

        header('Location: post.php?id=' . getPostIdFromReplyId($pdo, $replyId));
        exit;
      }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>