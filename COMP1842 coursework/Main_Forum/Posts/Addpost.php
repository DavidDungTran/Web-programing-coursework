<?php
include '../includes/Databaseconnection.php';
include '../includes/ForumDataBaseFunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $post = $_POST["post"];
    $topic_id = $_POST["topic"];

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'css'];

        if ($fileError === 0) {
            if (in_array($fileActualExt, $allowedExt)) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'Main_forum/uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $post .= "<br><a href=\"$fileDestination\">$fileName</a>";
                if (in_array($fileActualExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $post .= "<br><img src=\"$fileDestination\" alt=\"$fileName\">";
                }

                $user_id = getUserId($pdo, $_SESSION['username']);
                insertpost($pdo, $title, $post, $topic_id, $user_id);
            } else {
                echo "Invalid file format. Please upload a JPG, JPEG, PNG, GIF, MP4, or CSS file.";
            }
        } else {
            echo "Error uploading file!";
        }
    } else {
        $user_id = getUserId($pdo, $_SESSION['username']);
        insertpost($pdo, $title, $post, $topic_id, $user_id);
    }

    header("Location:../forum_index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Post</title>
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
    </style>
</head>
<body>
    <h1 class="text-center mt-5">Add Post</h1>
    <?php
    $topics = allTopics($pdo);
    ?>
    <div class="container mt-5">
        <form action="addpost.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="post" class="form-label">Post:</label>
                <textarea class="form-control" id="post" name="post" rows="10" required></textarea>
            </div>
            <div class="mb-3">
                <label for="topic" class="form-label">Topic:</label>
                <select class="form-select" id="topic" name="topic" required>
                    <?php foreach ($topics as $topic) { ?>
                        <option value="<?php echo $topic['topic_id']; ?>"><?php echo $topic['title']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Upload File:</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9f