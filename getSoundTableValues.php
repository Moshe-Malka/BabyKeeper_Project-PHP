<?	
	include 'connection.php';
	
	//	parameter that got sent.
	$raspberry_product_key = $_POST["raspberry_product_key"];
	$timeRange = $_POST["timeRange"];
	
	//	Column names :
	$current_time_column;
	$value_column;
	$rasp_link_column;

	$response = array();
	$row_count = 0;
	
	// Create connection
    $conn = mysqli_connect($DATABASE_SITE, $USERNAME, $PASSWORD, $DATABASE_NAME);
	
	// this is our statment. contains a connection object and a statment.
	$statement = mysqli_prepare($conn, "SELECT * FROM sound_log WHERE `rasp_link` = ? AND `current_time` >= ? ");
	mysqli_stmt_bind_param($statement, "ss" ,$raspberry_product_key, $timeRange);	
    //this exacutes our statement.
	mysqli_stmt_execute($statement);	
	mysqli_stmt_bind_result($statement, $current_time_column, $value_column,$rasp_link_column);

	
	while (mysqli_stmt_fetch($statement)) {
		$response[$row_count] = array($current_time_column, $value_column,$rasp_link_column);
		$row_count++;
    }
    echo json_encode($response);		// here we send our response object encoded to Json format.
	
	mysqli_stmt_close($statement);
	mysqli_close($conn);
?>