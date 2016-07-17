<?php
	include 'connection.php';

    $conn = mysqli_connect($DATABASE_SITE, $USERNAME, $PASSWORD, $DATABASE_NAME);
	
	$email = $_POST["email"];
	$password;
	
	$statement = mysqli_prepare($con, "SELECT password FROM users WHERE email = ? ");	
	mysqli_stmt_bind_param($statement, "s", $email);
	mysqli_stmt_execute($statement);
	mysqli_stmt_store_result($statement);
	mysqli_stmt_bind_result($statement, $password);
	
	$response = array();	
	$response["success"] = false;
	
	while(mysqli_stmt_fetch($statement)){
	
		$response["success"] = true;
        $response["password"] = $password;
	}
	echo json_encode($response);	
	mysqli_close($con);

?>