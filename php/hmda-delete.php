<?php 
	
	include 'config.php';
	$dbCon = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password);

	
	if($dbCon) {
		try {
			if($_POST['incomplete'] === true || $_POST['incomplete'] === 'true') {
				$sql = 'DELETE FROM incompletes WHERE `loan_number`=?';
			} else {
				$sql = 'DELETE FROM hmda_lar WHERE `loan_number`=?';
			}
			$stmt = $dbCon->prepare($sql);
			$stmt->execute(array(intval($_POST['account'])));
			$count = $stmt->rowCount();
			if($count===1) {
				echo "success";
			} else {
				echo "Failed to delete record.";
			}
		} catch(PDOException $e) {
    		echo "Error: " . $e->getMessage();
    	}
	} else {
	  echo 'Connection error';
	}

?>