<?php 
	
	include 'config.php';

	if($_POST['checked']=='false') {
		$checked = 1;
	} else {
		$checked = 0;
	}

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if($_POST['incomplete'] === true || $_POST['incomplete'] === 'true') {
			$stmt = $conn->prepare("UPDATE incompletes SET checked=? WHERE loan_number=?");
		} else {
			$stmt = $conn->prepare("UPDATE hmda_lar SET checked=? WHERE loan_number=?");
		}

		$stmt->execute([$checked,$_POST['loan_number']]);
		echo "success";
	} catch(PDOException $e) {
    	echo "Error: " . $e->getMessage();
    }
	$conn = null;

?>