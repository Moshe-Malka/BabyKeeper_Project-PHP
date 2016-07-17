<?php
	include 'check_raspberry_id.php';
	include 'connection.php';
	
	$email = $_POST["email"];
	$password = $_POST["password"];
	$raspberry_product_key = $_POST["raspberry_product_key"];
	
	// Create connection
    $conn = mysqli_connect($DATABASE_SITE, $USERNAME, $PASSWORD, $DATABASE_NAME);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	} 
	
	$response = array();
	$response["valid_key"] = check_raspberry_id($raspberry_product_key);
	
	$first_statement = mysqli_prepare($conn, "INSERT INTO users (email , password) VALUES (? , ?)");		
	mysqli_stmt_bind_param($first_statement, "ss", $email, $password);				
    
	if(mysqli_stmt_execute($first_statement))
	{
		$response["first_insert_success"] = true;
	}	
	else{
		$response["first_insert_success"] = false;
		$response["first_reason"] = "User already exists !";
	}
	mysqli_stmt_close($first_statement);

	///////////////////////////////////************************************///////////////////////////////////////
	$second_statement = mysqli_prepare($conn, "INSERT INTO rasppberry_pi (raspberry_product_key	, linked_user_email	) VALUES (?, ?)");		
	mysqli_stmt_bind_param($second_statement, "ss", $raspberry_product_key, $email);				

	if(mysqli_stmt_execute($second_statement))
	{
		$response["second_insert_success"] = true;
	}	
	else{
		$response["second_insert_success"] = false;
		$response["second_reason"] = "Device already exists !";
	}
	mysqli_stmt_close($second_statement);

	///////////////////////////////////************************************///////////////////////////////////////
	
	echo json_encode($response);
	mysqli_close($conn);

?>