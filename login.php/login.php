<?php

include("connection.php");

$userExist = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM login";
    $result = sqlsrv_query($conn, $sql);
    if ($result === false) {

        die(print_r(sqlsrv_errors(), true));
    }
    $unsereTabelle = [];
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        if (isset($row['email']) && $row['password'] !== null) {
            if($row['email'] == $username && $row['password'] == $password){
                $userExist = true;
                $currentUser = $row['email'];
            }
            array_push($unsereTabelle, array(
                $id = $row["id"],
                $email = $row["email"],
                $passwort = $row["password"],
                // $obj = new Account($row["id"], $row["email"], $row["password"])
            ));
        }
    };
    if($userExist == true){
        echo "willkommen " . $currentUser;
    }else{
        header("Location: index.php");
        exit();
    }


}
