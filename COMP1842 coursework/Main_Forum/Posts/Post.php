<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post</title>
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
      .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
      }
      .card-body {
        padding: 20px;
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
      .btn-red {
        background-color: #ff0000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
      }
      .btn-red:hover {
        background-color: #cc0000;
      }
    </style>
  </head>
  <body>
    <h1 class="text-center mt-5">Post</h1>
    <?php
      include '../includes/Databaseconnection.php';
      include '../includes/ForumDataBaseFunctions.php';

      if (!$pdo) {
        die("Connection failed: " . mysqli_connect_error());
      }

      if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        $post = getPost($pdo, $postId);
        if ($post) {
    ?>
    <div class="container mt-5">
    <h2><?php echo $post['title']; ?></h2>
    <p>Topic: <?php echo gettopic($pdo, $post['topic_id'])['title']; ?></p>
    <p>Date posted: <?php echo $post['created_at']; ?></p>
    <div class="card">
    <?php if (!empty($post['file_path'])) { ?>
        <?php
            $filePath = 'Main_forum/uploads/'.$post['file_path'];
            if (file_exists($filePath)) {
                echo '<img src="'.$filePath.'" alt="Uploaded Image" style="max-width: 100%; height: auto;"/>';
            } else {
                echo 'Image not found';
            }
        ?>
    <?php } ?>
    <div class="card-body">
        <?php echo nl2br($post['content']); ?>
    </div>
</div>
      <div class="button-container">
          <button class="btn-blue-sky" onclick="document.getElementById('reply-form').submit()">Reply</button>
          <form id="reply-form" action="add_reply.php" method="post">
              <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
              <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
              <input type="text" name="content" id="reply-input" placeholder="Type your reply here...">
          </form>
          <button class="btn-blue-sky" onclick="location.href='edit_post.php?id=<?php echo $post['post_id']; ?>'">Edit post</button>
          <button class="btn-red" onclick="deletePost(<?php echo $post['post_id']; ?>)">Delete Post</button>
          </div>
      <?php
        $replies = allReplies($pdo, $postId); // Pass post ID to allReplies function
        if ($replies) {
          foreach ($replies as $reply) {
      ?>
      <div class="card">
        <div class="card-body">
          <p><?php echo getuser($pdo, $reply['user_id'])['username']; ?> replied:</p>
          <p><?php echo nl2br($reply['content']); ?></p>
          <p>Date: <?php echo $reply['created_at']; ?></p>
          <div class="button-container" style="float: right;">
            <button class="btn-blue-sky" onclick="location.href='edit_reply.php?id=<?php echo $reply['reply_id']; ?>'">Edit reply</button>
            <button class="btn-red" onclick="deleteReply(<?php echo $reply['reply_id']; ?>)">Delete Reply</button>
          </div>
          </div>
      </div>
      <?php
          }
        } else {
          echo 'No replies found';
        }
      ?>
    </div>
    <?php
        } else {
          echo 'Post not found';
        }
      } else {
        echo 'No post ID specified';
      }
    ?>
    <script>
      function reply(postId) {
        var replyInput = document.getElementById('reply-input').value;
        var userId = <?php echo $_SESSION['user_id']; ?>;
        if (replyInput.trim() === '') {
          alert('Please enter a reply before submitting.');
          return;
        }
        // Add code to handle reply submission here
        var form = document.getElementById('reply-form');
        form.action = 'add_reply.php?id=' + postId;
        form.submit();
      }
    </script>

</div>
</div>
</div>

<script>
function deleteReply(replyId) {
    if (confirm("Are you sure you want to delete this reply?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_reply.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("reply_id=" + replyId);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Reply deleted successfully");
                // Refresh the page to see the changes
                location.reload();
            } else {
                alert("Error deleting reply");
            }
        };
    }
}
function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_post.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("post_id=" + postId);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Post deleted successfully");
                // Refresh the page to see the changes
                location.reload();
            } else {
                alert("Error deleting post");
            }
        };
    }
}
</script>

</body>
</html>
