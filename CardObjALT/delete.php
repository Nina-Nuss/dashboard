<?php
function delete($deleteEle)
{
     include("connection.php");

     // Validate input
     if (!isset($deleteEle) || empty($deleteEle)) {
          echo 'Error: No data received';
          return;
     }

     // Sanitize input to prevent SQL injection

     // Prepare and execute the SQL statement
     $sql = "DELETE FROM images WHERE image_name = ?";
     $params = array($deleteEle);
     $stmt = sqlsrv_prepare($conn, $sql, $params);

     if (!$stmt) {
          die(print_r(sqlsrv_errors(), true));
     }

     if (!sqlsrv_execute($stmt)) {
          die(print_r(sqlsrv_errors(), true));
     }

     // Check for affected rows
     $rowsAffected = sqlsrv_rows_affected($stmt);
     if ($rowsAffected > 0) {
          echo "Image deleted successfully";
     } else {
          echo "No image found for deletion";
     }

     // Close the statement and connection
     sqlsrv_free_stmt($stmt);
     sqlsrv_close($conn);
}
