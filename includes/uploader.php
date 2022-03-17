<?php

require "./config/db.php";
include './template/filters.php';
$uploadsFolder = 'uploads';





$name = $email = $message = $service = '';

$nameError = $emailError = $messageError = $documentError = $serviceError = '';


if($_SERVER['REQUEST_METHOD'] == 'POST') {


    $name = filterString($_POST['name']);
    if(!$name) { 

        $nameError = "Name is required";
        $_SESSION['contactForm']['name'] = '';

    } else {

        $_SESSION['contactForm']['name'] = $name;

    }

    $email = filterEmail($_POST['email']);
    if(!$email) {

        $emailError = "Email is required";
        $_SESSION['contactForm']['email'] = '';

    } else {

        $_SESSION['contactForm']['email'] = $email;

    }


    $service = filterString($_POST['services']);

    if(!$service) {

        $serviceError = "Service is Required";
        $_SESSION['contactForm']['services'] = '';
    } else {

        $_SESSION['contactForm']['services'] = $service;
        
    }

    $message = filterString($_POST['message']);
    if(!$message) {

        $messageError = "Message is required";
        $_SESSION['contactForm']['message'] = '';

    } else {

        $_SESSION['contactForm']['message'] = $message;

    }


    if(isset($_FILES['document']) && $_FILES['document']['error'] == 0) {

        $upload = canUpload($_FILES['document']);

        if($upload === true) {
            
            if(!is_dir($uploadsFolder)) {
                
                umask(0);
                mkdir($uploadsFolder, 0775);
                
            }

            $fileName = time() . $_FILES['document']['name'];

            if(file_exists($uploadsFolder . '/' . $fileName)) {

                $documentError = 'File already exists';

            } else {

                move_uploaded_file($_FILES['document']['tmp_name'], $uploadsFolder . '/' . $fileName);

            }
            
        } else {

            $documentError = $upload;

        }
    }

    if(!$nameError && !$messageError && !$documentError && !$emailError && !$serviceError) {

        $fileName ? $filePath = $uploadsFolder . '/' . $fileName : $filePath = ''; 

        $statement = $mySqli->prepare("INSERT INTO messages (contact_name, email, document, message, service_id) VALUES (?, ?, ?, ?, ?)");

        $statement->bind_param('ssssi', $dbName, $dbEmail, $dbDocument, $dbMessage, $dbServiceId);


        $dbName = $name;
        $dbEmail = $email;
        $dbDocument = $fileName;
        $dbMessage = $message;
        $dbServiceId = $service;

        $statement->execute();

        $mySqli->close();


        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
        // $headers .= 'From: '.$email."\r\n". 'Reply-To: '.$email."\r\n" . 'X-Mailer: PHP/' . phpversion();

        // $htmlMessage = "<html><body>";
        // $htmlMessage .= "<p style = 'color: #ff0000;'>$message</p>";
        // $htmlMessage .= "</body></html>";

        // if(mail($appInfo['adminEmail'], 'You have a new message', $message)){ 
       
            unset($_SESSION['contactForm']);
            //session_destroy();
            header('Location: index.php');
            die();

        // } else {

        //     return false;

        // }

    }

}