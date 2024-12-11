<?php
    //start PHP session
    session_start();
  
    //check if admin is logged in
    if(isset($_SESSION['admin'])){
        //redirect to admin page
        header('Location: adminpage.php');
        exit;
    }
  
    //include our database connection
    include 'Includes/Databaseconnection.php';
    include 'Includes/Forumdatabasefunctions.php'; // New included line
  
    //check if form is submitted
    if(isset($_POST['submit'])){
        //get the email and password
        $email = $_POST['email'];
        $password = $_POST['password'];
  
        //check if email and password match
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ? AND password = ?');
        $stmt->execute([$email, $password]);
        $admin = $stmt->fetch();
  
        if($admin){
            //set admin session variable
            $_SESSION['admin'] = true;
  
            //redirect to admin page
            header('Location: adminpage.php');
            exit;
        } else {
            //display error message
            $error = 'Invalid email or password';
        }
    }
?>
  
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>