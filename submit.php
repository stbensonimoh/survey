<?php
// Pull in the Database Configuration file
require 'dbconfig.php';

//  Capture Post Data that is sent from the form through the main.js file
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$chapter = $_POST['chapter'];
$howToBePromoted = $_POST['howToBePromoted'];
$showcase = $_POST['showcase'];
$productsNservices = $_POST['productsNservices'];

//  Connect to the Database using PDO

$dsn = "mysql:host=$host;dbname=$db";
//Create PDO Connection with the dbconfig data
$conn = new PDO($dsn, $username, $password);

// Check to see if the user is in the database already
$usercheck = "SELECT * FROM awlo_showcase WHERE email=?";
// prepare the Query
$usercheckquery = $conn->prepare($usercheck);
//Execute the Query
$usercheckquery->execute(array("$email"));
//Fetch the Result
$usercheckquery->rowCount();
if ($usercheckquery->rowCount() > 0) {
    echo "user_exists";
} else {
    // Insert the user into the database
    $enteruser = "INSERT into awlo_showcase (firstName, lastName, email, phone, chapter, howToBePromoted, showcase, productsNservices) VALUES (:firstName, :lastName, :email, :phone, :chapter, :howToBePromoted, :showcase, :productsNservices)";
    //  Prepare Query
    $enteruserquery = $conn->prepare($enteruser);
    //  Execute the Query
    $enteruserquery->execute(
        array(
            "firstName"         =>      $firstName,
            "lastName"          =>      $lastName,
            "email"             =>      $email,
            "phone"             =>      $phone,
            "chapter"           =>      $chapter,
            "howToBePromoted"   =>      $howToBePromoted,
            "showcase"          =>      $showcase,
            "productsNservices" =>      $productsNservices
        )
    );

    //  Fetch Result
    $enteruserquery->rowCount();
    // Check to see if the query executed successfully
    if($enteruserquery->rowCount() > 0) {
        echo "success";
    }
}
