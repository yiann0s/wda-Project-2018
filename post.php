<?php
    $message      = $_POST["message"];
    $firstName   = $_POST["firstName"];
    $lastName    = $_POST["lastName"];
    $email       = $_POST["email"];
    if(isset($message)){
        $data = array(
            "User message"     => $message,
            "User firstName"  => $firstName,
            "User lastName"   => $lastName,
            "User email"      => $email
        );
        echo json_encode($data);
    }
?>