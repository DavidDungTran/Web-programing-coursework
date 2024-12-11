<?php
    //start PHP session
    session_start();
  
    //check if login form is submitted
    if(isset($_POST['login'])){
        //assign variables to post values
        $email = $_POST['email'];
        $password = $_POST['password'];
  
        //include our database connection
        include 'Email_conn.php';
  
        //get the user with email
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
  
        try{
            $stmt->execute(['email' => $email]);
  
            //check if email exist
            if($stmt->rowCount() > 0){
                //get the row
                $user = $stmt->fetch();
  
                //validate inputted password with $user password
                if(password_verify($password, $user['password'])){
                    //action after a successful login
                    $_SESSION['success'] = 'User verification successful';
                    header('Location: ../Main_Forum/Forum_index.php');
                    exit; // Add this line to stop the script from continuing
                }
                else{
                    //return the values to the user
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
  
                    $_SESSION['error'] = 'Incorrect password';
                    header('location: login_index.php'); // Redirect back to login page
                }
  
            }
            else{
                //return the values to the user
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
  
                $_SESSION['error'] = 'No account associated with the email';
                header('location: login_index.php'); // Redirect back to login page
            }
  
        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
            header('location: login_index.php'); // Redirect back to login page
        }
  
    }
    else{
        $_SESSION['error'] = 'Fill up login form first';
        header('location: login_index.php'); // Redirect back to login page
    }
?>
    