<?php 
	
	include 'config.php';

	foreach($_POST as $key => $value) {
		if ($value === '') {
			$_POST[$key] = null;
		}
	}


	$orig_number = filter_var($_POST["orig_number"], FILTER_SANITIZE_NUMBER_INT);
	$loan_number = filter_var($_POST["loan_number"], FILTER_SANITIZE_NUMBER_INT);
	if($_POST["app_date"] != "NA") {
		$app_date = filter_var($_POST["app_date"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$app_date = $_POST["app_date"];
	}
	if($_POST["loan_type"] != '') {
		$loan_type = filter_var($_POST["loan_type"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$loan_type = null;
	}
	$prop_type = filter_var($_POST["prop_type"], FILTER_SANITIZE_NUMBER_INT);
	if($_POST["purpose"] != '') {
		$purpose = filter_var($_POST["purpose"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$purpose = null;
	}
	$occupancy = filter_var($_POST["occupancy"], FILTER_SANITIZE_NUMBER_INT);
	$amount = filter_var($_POST["amount"], FILTER_SANITIZE_NUMBER_INT);
	$preapproval = filter_var($_POST["preapproval"], FILTER_SANITIZE_NUMBER_INT);
	$action = filter_var($_POST["action"], FILTER_SANITIZE_NUMBER_INT);
	$action_date = filter_var($_POST["action_date"], FILTER_SANITIZE_NUMBER_INT);
	if($_POST["msa"] != "NA") {
		$msa = filter_var($_POST["msa"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$msa = $_POST["msa"];
	}
	if($_POST["state"] != "NA") {
		$state = filter_var($_POST["state"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$state = $_POST["state"];
	}
	if($_POST["county"] != "NA") {
		$county = filter_var($_POST["county"], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$county = $_POST["county"];
	}
	if($_POST["census"] != "NA") {
		$census = filter_var($_POST["census"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	} else {
		$census = $_POST["census"];
	}
	$app_ethnicity = filter_var($_POST["app_ethnicity"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_ethnicity = filter_var($_POST["coapp_ethnicity"], FILTER_SANITIZE_NUMBER_INT);
	$app_race1 = filter_var($_POST["app_race1"], FILTER_SANITIZE_NUMBER_INT);
	$app_race2 = filter_var($_POST["app_race2"], FILTER_SANITIZE_NUMBER_INT);
	$app_race3 = filter_var($_POST["app_race3"], FILTER_SANITIZE_NUMBER_INT);
	$app_race4 = filter_var($_POST["app_race4"], FILTER_SANITIZE_NUMBER_INT);
	$app_race5 = filter_var($_POST["app_race5"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race1 = filter_var($_POST["coapp_race1"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race2 = filter_var($_POST["coapp_race2"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race3 = filter_var($_POST["coapp_race3"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race4 = filter_var($_POST["coapp_race4"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_race5 = filter_var($_POST["coapp_race5"], FILTER_SANITIZE_NUMBER_INT);
	$app_sex = filter_var($_POST["app_sex"], FILTER_SANITIZE_NUMBER_INT);
	$coapp_sex = filter_var($_POST["coapp_sex"], FILTER_SANITIZE_NUMBER_INT);
	$income = filter_var($_POST["income"], FILTER_SANITIZE_NUMBER_INT);
	$purchaser_type = filter_var($_POST["purchaser_type"], FILTER_SANITIZE_NUMBER_INT);
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
	$hoepa = filter_var($_POST["hoepa"], FILTER_SANITIZE_NUMBER_INT);
	$lien = filter_var($_POST["lien"], FILTER_SANITIZE_NUMBER_INT);

	$app_fname = filter_var($_POST["app_fname"], FILTER_SANITIZE_STRING);
	$app_lname = filter_var($_POST["app_lname"], FILTER_SANITIZE_STRING);
	$coapp_fname = filter_var($_POST["coapp_fname"], FILTER_SANITIZE_STRING);
	$coapp_lname = filter_var($_POST["coapp_lname"], FILTER_SANITIZE_STRING);
	$edited_by = filter_var($_POST["edited_by"], FILTER_SANITIZE_STRING);

	if($_POST['incomplete'] === true || $_POST['incomplete'] === 'true') {
		try {
			$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$conn->beginTransaction();
			$stmt = $conn->prepare("INSERT INTO hmda_lar SELECT * FROM incompletes WHERE loan_number=?");
			$stmt->execute([$loan_number]);
			$stmt2 = $conn->prepare("DELETE FROM incompletes WHERE loan_number=?");
			$stmt2->execute([$loan_number]);
			$conn->commit();

			$rowsAffected = $stmt2->rowCount();
			if($rowsAffected === 0) {
				$stmt = $conn->prepare("UPDATE incompletes SET loan_number=?, app_date=?, loan_type=?, prop_type=?, purpose=?, occupancy=?, amount=?, preapproval=?, action=?,"
			. "action_date=?, msa=?, state=?, county=?, census=?, app_ethnicity=?, coapp_ethnicity=?, app_race1=?, app_race2=?, app_race3=?, app_race4=?, app_race5=?,"
			. "coapp_race1=?, coapp_race2=?, coapp_race3=?, coapp_race4=?, coapp_race5=?, app_sex=?, coapp_sex=?, income=?, purchaser_type=?, denial_reason1=?,"
			. "denial_reason2=?, denial_reason3=?, spread=?, hoepa=?, lien=?, app_fname=?, app_lname=?, coapp_fname=?, coapp_lname=?, edited_by=?, last_edited=CURRENT_TIMESTAMP WHERE loan_number=?");
				$stmt->execute([$loan_number, $app_date, $loan_type, $prop_type, $purpose, $occupancy, $amount, $preapproval, $action, $action_date, $msa, $state, 
			$county, $census, $app_ethnicity, $coapp_ethnicity, $app_race1, $app_race2, $app_race3, $app_race4, $app_race5, $coapp_race1, $coapp_race2, $coapp_race3,
			$coapp_race4, $coapp_race5, $app_sex, $coapp_sex, $income, $purchaser_type, $denial_reason1, $denial_reason2, $denial_reason3, $spread, $hoepa, $lien,
			$app_fname, $app_lname, $coapp_fname, $coapp_lname, $edited_by, $orig_number]);
				echo "An error occured.  Please refresh the page and confirm your record has been updated.";
			} else {
				echo "Record updated successfully.  This record is now complete.";
			}
		} catch(PDOException $e) {
			$conn->commit();
			$transaction_failed = TRUE;	
		}

	} else {
		try {
			$conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("UPDATE hmda_lar SET loan_number=:loan_number, app_date=:app_date, loan_type=:loan_type, prop_type=:prop_type, purpose=:purpose, occupancy=:occupancy,"
			. " amount=:amount, preapproval=:preapproval, action=:action,action_date=:action_date, msa=:msa, state=:state, county=:county, census=:census, app_ethnicity=:app_ethnicity,"
			. "coapp_ethnicity=:coapp_ethnicity, app_race1=:app_race1, app_race2=:app_race2, app_race3=:app_race3, app_race4=:app_race4, app_race5=:app_race5,"
			. "coapp_race1=:coapp_race1, coapp_race2=:coapp_race2, coapp_race3=:coapp_race3, coapp_race4=:coapp_race4, coapp_race5=:coapp_race5, app_sex=:app_sex,"
			. "coapp_sex=:coapp_sex, income=:income, purchaser_type=:purchaser_type, denial_reason1=:denial_reason1, denial_reason2=:denial_reason2, denial_reason3=:denial_reason3,"
			. "spread=:spread, hoepa=:hoepa, lien=:lien, app_fname=:app_fname, app_lname=:app_lname, coapp_fname=:coapp_fname, coapp_lname=:coapp_lname, edited_by=:edited_by,"
			. "last_edited=CURRENT_TIMESTAMP WHERE loan_number=:orig_number");
			
			$stmt->bindValue(':loan_number', $loan_number);
			$stmt->bindValue(':app_date', $app_date);
			$stmt->bindValue(':loan_type', $loan_type);
			$stmt->bindValue(':prop_type', $prop_type);
			$stmt->bindValue(':purpose', $purpose);
			$stmt->bindValue(':occupancy', $occupancy);
			$stmt->bindValue(':amount', $amount);
			$stmt->bindValue(':preapproval', $preapproval);
			$stmt->bindValue(':action', $action);
			$stmt->bindValue(':action_date', $action_date);
			$stmt->bindValue(':msa', $msa);
			$stmt->bindValue(':state', $state);
			$stmt->bindValue(':county', $county);
			$stmt->bindValue(':census', $census);
			$stmt->bindValue(':app_ethnicity', $app_ethnicity);
			$stmt->bindValue(':coapp_ethnicity', $coapp_ethnicity);
			$stmt->bindValue(':app_race1', $app_race1);
			$stmt->bindValue(':app_race2', $app_race2);
			$stmt->bindValue(':app_race3', $app_race3);
			$stmt->bindValue(':app_race4', $app_race4);
			$stmt->bindValue(':app_race5', $app_race5);
			$stmt->bindValue(':coapp_race1', $coapp_race1);
			$stmt->bindValue(':coapp_race2', $coapp_race2);
			$stmt->bindValue(':coapp_race3', $coapp_race3);
			$stmt->bindValue(':coapp_race4', $coapp_race4);
			$stmt->bindValue(':coapp_race5', $coapp_race5);
			$stmt->bindValue(':app_sex', $app_sex);
			$stmt->bindValue(':coapp_sex', $coapp_sex);
			$stmt->bindValue(':income', $income);
			$stmt->bindValue(':purchaser_type', $purchaser_type);
			$stmt->bindValue(':denial_reason1', $denial_reason1);
			$stmt->bindValue(':denial_reason2', $denial_reason2);
			$stmt->bindValue(':denial_reason3', $denial_reason3);
			$stmt->bindValue(':spread', $spread);
			$stmt->bindValue(':hoepa', $hoepa);
			$stmt->bindValue(':lien', $lien);
			$stmt->bindValue(':app_fname', $app_fname);
			$stmt->bindValue(':app_lname', $app_lname);
			$stmt->bindValue(':coapp_fname', $coapp_fname);
			$stmt->bindValue(':coapp_lname', $coapp_lname);
			$stmt->bindValue(':edited_by', $edited_by);
			$stmt->bindValue(':orig_number', $orig_number);

			$stmt->execute();

			echo "success";
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}

	}

	if($transaction_failed === TRUE) {

		try {
				$stmt3 = $conn->prepare("UPDATE incompletes SET loan_number=:loan_number, app_date=:app_date, loan_type=:loan_type, prop_type=:prop_type, purpose=:purpose, occupancy=:occupancy,"
			. "amount=:amount, preapproval=:preapproval, action=:action, action_date=:action_date, msa=:msa, state=:state, county=:county, census=:census, app_ethnicity=:app_ethnicity,"
			. "coapp_ethnicity=:coapp_ethnicity, app_race1=:app_race1, app_race2=:app_race2, app_race3=:app_race3, app_race4=:app_race4, app_race5=:app_race5,"
			. "coapp_race1=:coapp_race1, coapp_race2=:coapp_race2, coapp_race3=:coapp_race3, coapp_race4=:coapp_race4, coapp_race5=:coapp_race5, app_sex=:app_sex,"
			. "coapp_sex=:coapp_sex, income=:income, purchaser_type=:purchaser_type, denial_reason1=:denial_reason1, denial_reason2=:denial_reason2, denial_reason3=:denial_reason3,"
			. "spread=:spread, hoepa=:hoepa, lien=:lien, app_fname=:app_fname, app_lname=:app_lname, coapp_fname=:coapp_fname, coapp_lname=:coapp_lname, edited_by=:edited_by,"
			. "last_edited=CURRENT_TIMESTAMP WHERE loan_number=:orig_number");
			
			$stmt3->bindValue(':loan_number', $loan_number);
			$stmt3->bindValue(':app_date', $app_date);
			if(is_null($loan_type) || empty($loan_type)) {
				$stmt3->bindValue(':loan_type', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':loan_type', $loan_type, PDO::PARAM_INT);
			}
			if(is_null($prop_type) || empty($prop_type)) {
				$stmt3->bindValue(':prop_type', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':prop_type', $prop_type, PDO::PARAM_INT);
			}
			if(is_null($purpose) || empty($purpose)) {
				$stmt3->bindValue(':purpose', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':purpose', $purpose, PDO::PARAM_INT);
			}
			if(is_null($occupancy) || empty($occupancy)) {
				$stmt3->bindValue(':occupancy', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':occupancy', $occpuancy, PDO::PARAM_INT);
			}
			if(is_null($amount) || empty($amount)) {
				$stmt3->bindValue(':amount', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':amount', $amount, PDO::PARAM_INT);
			}
			if(is_null($preapproval) || empty($preapproval)) {
				$stmt3->bindValue(':preapproval', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':preapproval', $preapproval, PDO::PARAM_INT);
			}
			if(is_null($action) || empty($action)) {
				$stmt3->bindValue(':action', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':action', $action, PDO::PARAM_INT);
			}
			if(is_null($action_date) || empty($action_date)) {
				$stmt3->bindValue(':action_date', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':action_date', $action_date, PDO::PARAM_INT);
			}
			if(is_null($msa) || empty($msa)) {
				$stmt3->bindValue(':msa', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':msa', $msa, PDO::PARAM_INT);
			}
			if(is_null($state) || empty($state)) {
				$stmt3->bindValue(':state', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':state', $state, PDO::PARAM_INT);
			}
			if(is_null($county) || empty($county)) {
				$stmt3->bindValue(':county', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':county', $county, PDO::PARAM_INT);
			}
			if(is_null($census) || empty($census)) {
				$stmt3->bindValue(':census', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':census', $census, PDO::PARAM_INT);
			}
			if(is_null($app_ethnicity) || empty($app_ethnicity)) {
				$stmt3->bindValue(':app_ethnicity', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_ethnicity', $app_ethnicity, PDO::PARAM_INT);
			}
			if(is_null($coapp_ethnicity) || empty($coapp_ethnicity)) {
				$stmt3->bindValue(':coapp_ethnicity', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_ethnicity', $coapp_ethnicity, PDO::PARAM_INT);
			}
			if(is_null($app_race1) || empty($app_race1)) {
				$stmt3->bindValue(':app_race1', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_race1', $app_race1, PDO::PARAM_INT);
			}
			if(is_null($app_race2) || empty($app_race2)) {
				$stmt3->bindValue(':app_race2', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_race2', $app_race2, PDO::PARAM_INT);
			}
			if(is_null($app_race3) || empty($app_race3)) {
				$stmt3->bindValue(':app_race3', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_race3', $app_race3, PDO::PARAM_INT);
			}
			if(is_null($app_race4) || empty($app_race4)) {
				$stmt3->bindValue(':app_race4', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_race4', $app_race4, PDO::PARAM_INT);
			}
			if(is_null($app_race5) || empty($app_race5)) {
				$stmt3->bindValue(':app_race5', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_race5', $app_race5, PDO::PARAM_INT);
			}
			if(is_null($coapp_race1) || empty($coapp_race1)) {
				$stmt3->bindValue(':coapp_race1', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_race1', $coapp_race1, PDO::PARAM_INT);
			}
			if(is_null($coapp_race2) || empty($coapp_race2)) {
				$stmt3->bindValue(':coapp_race2', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_race2', $coapp_race2, PDO::PARAM_INT);
			}
			if(is_null($coapp_race3) || empty($coapp_race3)) {
				$stmt3->bindValue(':coapp_race3', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_race3', $coapp_race3, PDO::PARAM_INT);
			}
			if(is_null($coapp_race4) || empty($coapp_race4)) {
				$stmt3->bindValue(':coapp_race4', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_race4', $coapp_race4, PDO::PARAM_INT);
			}
			if(is_null($coapp_race5) || empty($coapp_race5)) {
				$stmt3->bindValue(':coapp_race5', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_race5', $coapp_race5, PDO::PARAM_INT);
			}
			if(is_null($app_sex) || empty($app_sex)) {
				$stmt3->bindValue(':app_sex', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':app_sex', $app_sex, PDO::PARAM_INT);
			}
			if(is_null($coapp_sex) || empty($coapp_sex)) {
				$stmt3->bindValue(':coapp_sex', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':coapp_sex', $coapp_sex, PDO::PARAM_INT);
			}
			if(is_null($income) || empty($income)) {
				$stmt3->bindValue(':income', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':income', $income, PDO::PARAM_INT);
			}
			if(is_null($purchaser_type) || empty($purchaser_type)) {
				$stmt3->bindValue(':purchaser_type', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':purchaser_type', $purchaser_type, PDO::PARAM_INT);
			}
			if(is_null($denial_reason1) || empty($denial_reason1)) {
				$stmt3->bindValue(':denial_reason1', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':denial_reason1', $denial_reason1, PDO::PARAM_INT);
			}
			if(is_null($denial_reason2) || empty($denial_reason2)) {
				$stmt3->bindValue(':denial_reason2', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':denial_reason2', $denial_reason2, PDO::PARAM_INT);
			}
			if(is_null($denial_reason3) || empty($denial_reason3)) {
				$stmt3->bindValue(':denial_reason3', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':denial_reason3', $denial_reason3, PDO::PARAM_INT);
			}
			if(is_null($spread) || empty($spread)) {
				$stmt3->bindValue(':spread', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':spread', $spread, PDO::PARAM_INT);
			}
			if(is_null($hoepa) || empty($hoepa)) {
				$stmt3->bindValue(':hoepa', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':hoepa', $hoepa, PDO::PARAM_INT);
			}
			if(is_null($lien) || empty($lien)) {
				$stmt3->bindValue(':lien', null, PDO::PARAM_NULL);
			} else {
				$stmt3->bindValue(':lien', $lien, PDO::PARAM_INT);
			}
			$stmt3->bindValue(':app_fname', $app_fname);
			$stmt3->bindValue(':app_lname', $app_lname);
			$stmt3->bindValue(':coapp_fname', $coapp_fname);
			$stmt3->bindValue(':coapp_lname', $coapp_lname);
			$stmt3->bindValue(':edited_by', $edited_by);
			$stmt3->bindValue(':orig_number', $orig_number);

			$stmt3->execute();
			echo "Record updated successfully.  Please note this record is still incomplete.";
			
			} catch(PDOException $e2) {
				echo "Error: " . $e2->getMessage();
				$conn = null;
			}
			$conn = null;
		}
	$conn = null;


?>