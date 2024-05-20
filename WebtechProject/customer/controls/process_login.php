<?php
    include '../model/db_operations.php';

    session_start();
    if (isset($_SESSION["Email"])) {
        header("Location: ../view/dashboard.php");
    }

    $emailError = $passwordError = $loginError = "";
    $hasError = false;
    if (isset($_POST["login"])) {
        $userFound = false;

        if (empty($_POST["email"])) {
            $emailError = "Please enter your email address";
            $hasError = true;
        } 
        if (empty($_POST["password"])) {
            $passwordError = "Please enter your password";
            $hasError = true;
        } 
        if(!$hasError) {
            $dbOperations = new DatabaseOperations();
            $connection = $dbOperations->openConnection();

            $email = $_POST["email"];
            $password = $_POST["password"];

            $loginResult = $dbOperations->loginUser("customer", $email, $password);

            if ($loginResult) {
                $_SESSION["Email"] = $_POST["email"];
                setcookie("user", $_SESSION["Email"], time() + 3600, "/");
                header("Location: ../view/dashboard.php");
            } else {
                $loginError = "Login failed. Please check your credentials.";
            }

            $dbOperations->closeConnection();
        }
    }
?>
