<?php

// ini_set("display_errors", 1);
// ini_set("display_startup_errors", 1);
// error_reporting(E_ALL);
$guid = bin2hex(openssl_random_pseudo_bytes(16));

if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
  // $Now = new DateTime('now', new DateTimeZone('Europe/Berlin'));
  // move_uploaded_file($_FILES["file"]["tmp_name"], "../images/" . $Now->format('Y-m-d-H-i-s') ."-". $_FILES["file"]["name"]);
  //move_uploaded_file($_FILES["file"]["tmp_name"], "../images/" . $_FILES["file"]["name"]);
  move_uploaded_file($_FILES["file"]["tmp_name"], "../images/" . $guid . "." . explode(".", $_FILES["file"]["name"])[1]);
  echo "../images/" . $guid . "." . explode(".", $_FILES["file"]["name"])[1];

  //$_FILES["file"]["name"] //Endung nach dem . bekommen durch splitt

  // echo true;
} else {
  echo false;
}

?>