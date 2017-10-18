<?php
	include 'config.php';

	if($_POST['incomplete']) {
		$table = "incompletes";
	} else {
		$table = "hmda_lar";
	}
	
	$loan_number = filter_var($_POST["loan_number"], FILTER_SANITIZE_NUMBER_INT);
	if($loan_number==='') {
		$loan_number = null;
	}
	if($_POST["app_date"] != "NA") {
		$app_date = filter_var($_POST["app_date"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$app_date = $_POST["app_date"];
	}
	if($app_date==='') {
		$app_date = null;
	}
	$loan_type = filter_var($_POST["loan_type"], FILTER_SANITIZE_NUMBER_INT);
	if($loan_type==='') {
		$loan_type = null;
	}
	$prop_type = filter_var($_POST["prop_type"], FILTER_SANITIZE_NUMBER_INT);
	if($prop_type==='') {
		$prop_type = null;
	}
	$purpose = filter_var($_POST["purpose"], FILTER_SANITIZE_NUMBER_INT);
	if($purpose==='') {
		$purpose = null;
	}
	$occupancy = filter_var($_POST["occupancy"], FILTER_SANITIZE_NUMBER_INT);
	if($occupancy==='') {
		$occupancy = null;
	}
	$amount = filter_var($_POST["amount"], FILTER_SANITIZE_NUMBER_INT);
	if($amount==='') {
		$amount = null;
	}
	$preapproval = filter_var($_POST["preapproval"], FILTER_SANITIZE_NUMBER_INT);
	if($preapproval==='') {
		$preapproval = null;
	}
	$action = filter_var($_POST["action"], FILTER_SANITIZE_NUMBER_INT);
	if($action==='') {
		$action = null;
	}
	$action_date = filter_var($_POST["action_date"], FILTER_SANITIZE_NUMBER_INT);
	if($action_date==='') {
		$action_date = null;
	}
	if($_POST["msa"] != "NA") {
		$msa = filter_var($_POST["msa"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$msa = $_POST["msa"];
	}
	if($msa==='') {
		$msa = null;
	}
	if($_POST["state"] != "NA") {
		$state = filter_var($_POST["state"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$state = $_POST["state"];
	}
	if($state==='') {
		$state = null;
	}
	if($_POST["county"] != "NA") {
		$county = filter_var($_POST["county"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$county = $_POST["county"];
	}
	if($county==='') {
		$county = null;
	}
	if($_POST["census"] != "NA") {
		$census = filter_var($_POST["census"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	} else {
		$census = $_POST["census"];
	}
	if($census==='') {
		$census = null;
	}
	$app_ethnicity = filter_var($_POST["app_ethnicity"], FILTER_SANITIZE_NUMBER_INT);
	if($app_ethnicity==='') {
		$app_ethnicity = null;
	}
	$coapp_ethnicity = filter_var($_POST["coapp_ethnicity"], FILTER_SANITIZE_NUMBER_INT);
	if($coapp_ethnicity==='') {
		$coapp_ethnicity = null;
	}
	$app_race1 = filter_var($_POST["app_race1"], FILTER_SANITIZE_NUMBER_INT);
	if($app_race1==='') {
		$app_race1 = null;
	}
	$app_race2 = filter_var($_POST["app_race2"], FILTER_SANITIZE_NUMBER_INT);
	$app_race3 = filter_var($_POST["app_race3"], FILTER_SANITIZE_NUMBER_INT);
	$app_race4 = filter_var($_POST["app_race4"], FILTER_SANITIZE_NUMBER_INT);
	$app_race5 = filter_var($_POST["app_race5"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race1 = filter_var($_POST["coapp_race1"], FILTER_SANITIZE_NUMBER_INT);
	if($coapp_race1==='') {
		$coapp_race1 = null;
	}
	$coapp_race2 = filter_var($_POST["coapp_race2"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race3 = filter_var($_POST["coapp_race3"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race4 = filter_var($_POST["coapp_race4"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race5 = filter_var($_POST["coapp_race5"], FILTER_SANITIZE_NUMBER_INT);
	$app_sex = filter_var($_POST["app_sex"], FILTER_SANITIZE_NUMBER_INT);
	if($app_sex==='') {
		$app_sex = null;
	}
	$coapp_sex = filter_var($_POST["coapp_sex"], FILTER_SANITIZE_NUMBER_INT);
	if($coapp_sex==='') {
		$coapp_sex = null;
	}
	$income = filter_var($_POST["income"], FILTER_SANITIZE_NUMBER_INT);
	if($income==='') {
		$income = null;
	}
	$purchaser_type = filter_var($_POST["purchaser_type"], FILTER_SANITIZE_NUMBER_INT);
	if($purchaser_type==="") {
		$purchaser_type = null;
	}
	$denial_reason1 = filter_var($_POST["denial_reason1"], FILTER_SANITIZE_NUMBER_INT);
	if($denial_reason1==="") {
		$denial_reason1 = null;
	}
	$denial_reason2 = filter_var($_POST["denial_reason2"], FILTER_SANITIZE_NUMBER_INT);
	if($denial_reason2==="") {
		$denial_reason2 = null;
	}
	$denial_reason3 = filter_var($_POST["denial_reason3"], FILTER_SANITIZE_NUMBER_INT);
	if($denial_reason3==="") {
		$denial_reason3 = null;
	}
	if($_POST["spread"] != "NA") {
		$spread = filter_var($_POST["spread"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	} else {
		$spread = $_POST["spread"];
	}
	if($spread==="") {
		$spread = null;
	}
	$hoepa = filter_var($_POST["hoepa"], FILTER_SANITIZE_NUMBER_INT);
	if($hoepa==="") {
		$hoepa = null;
	}
	$lien = filter_var($_POST["lien"], FILTER_SANITIZE_NUMBER_INT);
	if($lien==="") {
		$lien = null;
	}
	$app_fname = filter_var($_POST["app_fname"], FILTER_SANITIZE_STRING);
	$app_lname = filter_var($_POST["app_lname"], FILTER_SANITIZE_STRING);
	$coapp_fname = filter_var($_POST["coapp_fname"], FILTER_SANITIZE_STRING);
	$coapp_lname = filter_var($_POST["coapp_lname"], FILTER_SANITIZE_STRING);
	$created_by = filter_var($_POST["created_by"], FILTER_SANITIZE_STRING);

	if($table==="hmda_lar") {
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $conn->prepare("INSERT INTO hmda_lar (loan_number, app_date, loan_type, prop_type, purpose, occupancy, amount, preapproval, action, action_date, msa, state," 
			. "county, census, app_ethnicity, coapp_ethnicity, app_race1, app_race2, app_race3, app_race4, app_race5, coapp_race1, coapp_race2, coapp_race3,"
			. "coapp_race4, coapp_race5, app_sex, coapp_sex, income, purchaser_type, denial_reason1, denial_reason2, denial_reason3, spread, hoepa, lien, app_fname, app_lname,"
			. "coapp_fname, coapp_lname, created_by) VALUES ("
			. "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->execute([$loan_number, $app_date, $loan_type, $prop_type, $purpose, $occupancy, $amount, $preapproval, $action, $action_date, $msa, $state, 
			$county, $census, $app_ethnicity, $coapp_ethnicity, $app_race1, $app_race2, $app_race3, $app_race4, $app_race5, $coapp_race1, $coapp_race2, $coapp_race3,
			$coapp_race4, $coapp_race5, $app_sex, $coapp_sex, $income, $purchaser_type, $denial_reason1, $denial_reason2, $denial_reason3, $spread, $hoepa, $lien,
			$app_fname, $app_lname, $coapp_fname, $coapp_lname, $created_by]);
			echo "Success!";
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage() . " h" . isset($_POST["incomplete"]);
		}
		$conn = null;
	} else {
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $conn->prepare("INSERT INTO incompletes (loan_number, app_date, loan_type, prop_type, purpose, occupancy, amount, preapproval, action, action_date, msa, state," 
			. "county, census, app_ethnicity, coapp_ethnicity, app_race1, app_race2, app_race3, app_race4, app_race5, coapp_race1, coapp_race2, coapp_race3,"
			. "coapp_race4, coapp_race5, app_sex, coapp_sex, income, purchaser_type, denial_reason1, denial_reason2, denial_reason3, spread, hoepa, lien, app_fname, app_lname,"
			. "coapp_fname, coapp_lname, created_by) VALUES ("
			. "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->execute([$loan_number, $app_date, $loan_type, $prop_type, $purpose, $occupancy, $amount, $preapproval, $action, $action_date, $msa, $state, 
			$county, $census, $app_ethnicity, $coapp_ethnicity, $app_race1, $app_race2, $app_race3, $app_race4, $app_race5, $coapp_race1, $coapp_race2, $coapp_race3,
			$coapp_race4, $coapp_race5, $app_sex, $coapp_sex, $income, $purchaser_type, $denial_reason1, $denial_reason2, $denial_reason3, $spread, $hoepa, $lien,
			$app_fname, $app_lname, $coapp_fname, $coapp_lname, $created_by]);
			echo "Success!";
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage() . " i" . isset($_POST["incomplete"]);
		}
		$conn = null;
	}
?>