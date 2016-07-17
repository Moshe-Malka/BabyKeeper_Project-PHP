<?php
	include 'connection.php';

    $conn = mysqli_connect($DATABASE_SITE, $USERNAME, $PASSWORD, $DATABASE_NAME);
    
	/*
		the http requst (babykeeper android app) posted two parameters - email and password.
	*/
    $email = $_POST["email"];
    $password = $_POST["password"];
	/* 
	$my_email="";
	$my_password=""; */
	
    $raspberry_product_key = "";			// a variable to hold the raspberry key
	
    $response = array();			// our response is initialized as an array
    $response["success"] = false;  		// the first key and value are entered ('success' = false by default).
	
    $statement = mysqli_prepare($con, "SELECT * FROM users WHERE email = ? AND password = ?");		// this is our statment. contains a connection object and a statment.
    mysqli_stmt_bind_param($statement, "ss", $email, $password);				// this binds the '?' sign to our variables
    mysqli_stmt_execute($statement);				//this exacutes our statement.
    mysqli_stmt_bind_result($statement, $email, $password);			// this tells it where to store it.
    
	include 'raspberry_product_key_retrival.php';
		
    if(mysqli_stmt_fetch($statement)){
        $response["success"] = true;
		$response["email"] = $email;
        $response["password"] = $password;
		$raspberry_product_key = getRasp($email);
		$response["raspberry_product_key"] = $raspberry_product_key;
		mysqli_stmt_close($statement);
	}
    echo json_encode($response);		// here we send our response object encoded to Json format.
	mysqli_close($con);

?>
