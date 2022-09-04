<?php

$Name = $_POST['Name'];
$Age = $_POST['Age'];
$email = $_POST['email'];
// $gender = $_POST['gender'];
// $dob = $_POST['dob'];

if (!empty($Name)  || !empty($Age) || !empty($email))
{
    $host = "localhost";
    $username = "root";
    $dbname = "corona";

    $conn = new mysqli($host, $username,'', $dbname);

    if (mysqli_connect_error()) {
        die ('Connect Error('. myql_connect_error().')'. mysqli_connect_error());
    } else {
        
        $SELECT = "SELECT email from covid Where email = ? Limit 1";
        $INSERT = "INSERT Into covid (Name, Age, email) values (?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sis", $Name, $Age, $email);
            $stmt->execute();
            echo "new record inserted sucessfully";

        } else {
            echo "someone already register using this email";
        }
        $stmt->close();
        $conn->close();
    }

} else {
    echo "All field are required";
    die();
}


?>