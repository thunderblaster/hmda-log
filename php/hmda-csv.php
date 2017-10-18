<?php
	include 'config.php';
	$db = new mysqli($servername, $username, $password, $dbname);

	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	
	$year = $_POST['year'];
	$start_date = $year . "0101";
	$end_date = $year . "1231";

	$sql = "SELECT * FROM hmda_lar WHERE action_date BETWEEN " . $start_date . " AND " . $end_date;
	
	if(!$result = $db->query($sql)){
		die('There was an error running the query [' . $db->error . ']');
	}
	$now = date("YmdHi");
	$count = mysqli_num_rows($result);
	echo "1|" . $respondent_id . "|" . $agency_code . "|" . $now . "|" . $year . "|" . $tin . "|" . $count . "|" . $respondent_name . "|" .
	 $respondent_address . "|" . $respondent_city . "|" . $respondent_state . "|" . $respondent_zip . "|" . $parent_name . "|" . $parent_address . 
	 "|" . $parent_city . "|" . $parent_state . "|" . $parent_zip . "|" . $contact_name . "|" . $contact_phone . "|" . $contact_fax . "|" . 
	 $contact_email . "|\r";


	
	while($row = $result->fetch_assoc()){
		$spread = number_format($row['spread'], 2);
		$spread = str_pad($spread, 5, '0', STR_PAD_LEFT);
		$state = $row['state'];
		$state = str_pad($state, 2, '0', STR_PAD_LEFT);
		$county = $row['county'];
		if($county != 'NA') {
			$county = str_pad($county, 3, '0', STR_PAD_LEFT);
		}
		$census = $row['census'];
		if($census != 'NA') {
			$census_exploded = explode('.', $census);
			$census_int = $census_exploded[0];
			$census_int = str_pad($census_int, 4, '0', STR_PAD_LEFT);
			$census_dec = $census_exploded[1];
			$census_dec = str_pad($census_dec, 2, '0', STR_PAD_RIGHT);
			$census = $census_int . '.' . $census_dec;
		}

		echo "2|2477|3|" . $row['loan_number'] . "|" . $row['app_date'] . "|" . $row['loan_type'] . "|" . 
		$row['prop_type'] . "|" . $row['purpose'] . "|" . $row['occupancy'] . "|" . $row['amount'] . "|" .
		$row['preapproval'] . "|" . $row['action'] . "|" . $row['action_date'] . "|" . $row['msa'] . "|" .
		$state . "|" . $county . "|" . $census . "|" . $row['app_ethnicity'] . "|" .
		$row['coapp_ethnicity'] . "|" . $row['app_race1'] . "|" . $row['app_race2'] . "|" .
		$row['app_race3'] . "|" . $row['app_race4'] . "|" . $row['app_race5'] . "|" . $row['coapp_race1'] . "|" .
		$row['coapp_race2'] . "|" . $row['coapp_race3'] . "|" . $row['coapp_race4'] . "|" . 
		$row['coapp_race5'] . "|" . $row['app_sex'] . "|" . $row['coapp_sex'] . "|" . $row['income'] . "|" .
		$row['purchaser_type']. "|" . $row['denial_reason1'] . "|" . $row['denial_reason2'] . "|" .
		$row['denial_reason3'] . "|" . $spread . "|" . $row['hoepa'] . "|" . $row['lien'] . "\r";
	}
	
	$result->free();
?>
