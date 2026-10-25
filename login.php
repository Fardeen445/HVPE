<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_email'],$_POST['login password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $sql ="SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if($result->num_rows ===1){
            $user = $result->fetch_assoc();
            if (password_verify($login_password, $user['password'])) {
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_email']= $user['email'];

            header("Location:Main1.html");
            exit();
            
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Email not registered";
    }
    $stmt->close();
    }
        
}
$conn->close();
?>