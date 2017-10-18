<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="../css/hmda.css">
		<script src="../js/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="../js/ad.js"></script>
	</head>
<body>
<?php
	include 'config.php';
	$db = new mysqli($servername, $username, $password, $dbname);

	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	
	$sql = "SELECT * FROM hmda_lar;";
	
	if(!$result = $db->query($sql)){
		die('There was an error running the query [' . $db->error . ']');
	}
	
	
	echo "<div align='center'><h2 id='logName'>HMDA Log</h2>
	<table class='table table-condensed table-hover table-bordered'><tr><th><i>Change</i></th><th>*</th><th><b>Applicant First Name</th><th>Applicant Last Name</th><th>Co-Applicant First Name</th>
	<th>Co-Applicant Last Name</th><th>Loan/App Number</th><th>Date App Received</th><th>Loan Type</th><th>Property Type</th><th>Loan Purpose</th>
	<th>Owner Occupancy</th><th>Loan Amount</th><th>Preapprovals</th><th>Action Taken</th><th>Date of Action</th><th>MSA</th><th>State Code</th>
	<th>County Code</th><th>Census Tract</th><th>Applicant Ethnicity</th><th>Co-Applicant Ethnicity</th><th>Applicant Race1</th><th>Applicant Race2</th>
	<th>Applicant Race3</th><th>Applicant Race4</th><th>Applicant Race5</th><th>Co-Applicant Race1</th><th>Co-Applicant Race2</th><th>Co-Applicant Race3</th>
	<th>Co-Applicant Race4</th><th>Co-Applicant Race5</th><th>Applicant Sex</th><th>Co-Applicant Sex</th><th>Applicant Income</th><th>Type of Purchaser</th>
	<th>Denial Reason1</th><th>Denial Reason2</th><th>Denial Reason3</th><th>Rate Spread</th><th>HOEPA Status</th><th>Lien Status</th><th>Added By</th><th>Datetime Added</th>
	<th>Edited By</th><th>Datetime Edited</th><th><i>Delete</i></th></tr>";
	
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
		

		if($row['checked']==1) {
			$star_box = "<button type='button' class='btn btn-warning glyphicon glyphicon-star' onClick='toggleStar(this)'></button>";
		} else {
			$star_box = "<button type='button' class='btn btn-default glyphicon glyphicon-star-empty' onClick='toggleStar(this)'></button>";
			
		}
		echo "<tr>" . "
		<td class='change-col'><button type='button' class='btn btn-info change-row glyphicon glyphicon-pencil' onClick='changeRow(this)'></button></td>
		<td>" . $star_box . "</td>
		<td class='changeable'><span class='original-value' data-col='app_fname'>" . $row['app_fname'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_lname'>" . $row['app_lname'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_fname'>" . $row['coapp_fname'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_lname'>" . $row['coapp_lname'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='loan_number'>" . $row['loan_number'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_date'>" . $row['app_date'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='loan_type'>" . $row['loan_type'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='prop_type'>" . $row['prop_type'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='purpose'>" . $row['purpose'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='occupancy'>" . $row['occupancy'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='amount'>" . $row['amount'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='preapproval'>" . $row['preapproval'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='action'>" . $row['action'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='action_date'>" . $row['action_date'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='msa'>" . $row['msa'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='state'>" . $state . "</span></td>
		<td class='changeable'><span class='original-value' data-col='county'>" . $county . "</span></td>
		<td class='changeable'><span class='original-value' data-col='census'>" . $census . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_ethnicity'>" . $row['app_ethnicity'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_ethnicity'>" . $row['coapp_ethnicity'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_race1'>" . $row['app_race1'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_race2'>" . $row['app_race2'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_race3'>" . $row['app_race3'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_race4'>" . $row['app_race4'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_race5'>" . $row['app_race5'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_race1'>" . $row['coapp_race1'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_race2'>" . $row['coapp_race2'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_race3'>" . $row['coapp_race3'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_race4'>" . $row['coapp_race4'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_race5'>" . $row['coapp_race5'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='app_sex'>" . $row['app_sex'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='coapp_sex'>" . $row['coapp_sex'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='income'>" . $row['income'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='purchaser_type'>" . $row['purchaser_type'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='denial_reason1'>" . $row['denial_reason1'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='denial_reason2'>" . $row['denial_reason2'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='denial_reason3'>" . $row['denial_reason3'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='spread'>" . $spread . "</span></td>
		<td class='changeable'><span class='original-value' data-col='hoepa'>" . $row['hoepa'] . "</span></td>
		<td class='changeable'><span class='original-value' data-col='lien'>" . $row['lien'] . "</span></td>
		<td class='text-nowrap'>" . $row['created_by'] . "</td>
		<td class='text-nowrap'>" . $row['added'] . "</td>
		<td class='text-nowrap'>" . $row['edited_by'] . "</td>
		<td class='text-nowrap'>" . $row['last_edited'] . "</td>
		<td><button type='button' class='btn btn-danger delete-row glyphicon glyphicon-trash' onClick='deleteRow(this)'></button></td>
		</tr>";
	}
	$result->free();

	$sql = "SELECT * FROM incompletes;";

	if(!$result = $db->query($sql)){
		die('There was an error running the query [' . $db->error . ']');
	}

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
		

		if($row['checked']==1) {
			$star_box = "<button type='button' class='btn btn-warning glyphicon glyphicon-star' onClick='toggleStar(this)'></button>";
		} else {
			$star_box = "<button type='button' class='btn btn-default glyphicon glyphicon-star-empty' onClick='toggleStar(this)'></button>";
			
		}
		echo "<tr>" . "
		<td class='change-col incomplete'><button type='button' class='btn btn-info change-row glyphicon glyphicon-pencil' onClick='changeRow(this)'></button></td>
		<td class='incomplete'>" . $star_box . "</td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_fname'>" . $row['app_fname'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_lname'>" . $row['app_lname'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_fname'>" . $row['coapp_fname'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_lname'>" . $row['coapp_lname'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='loan_number'>" . $row['loan_number'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_date'>" . $row['app_date'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='loan_type'>" . $row['loan_type'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='prop_type'>" . $row['prop_type'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='purpose'>" . $row['purpose'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='occupancy'>" . $row['occupancy'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='amount'>" . $row['amount'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='preapproval'>" . $row['preapproval'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='action'>" . $row['action'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='action_date'>" . $row['action_date'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='msa'>" . $row['msa'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='state'>" . $state . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='county'>" . $county . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='census'>" . $census . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_ethnicity'>" . $row['app_ethnicity'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_ethnicity'>" . $row['coapp_ethnicity'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_race1'>" . $row['app_race1'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_race2'>" . $row['app_race2'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_race3'>" . $row['app_race3'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_race4'>" . $row['app_race4'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_race5'>" . $row['app_race5'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_race1'>" . $row['coapp_race1'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_race2'>" . $row['coapp_race2'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_race3'>" . $row['coapp_race3'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_race4'>" . $row['coapp_race4'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_race5'>" . $row['coapp_race5'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='app_sex'>" . $row['app_sex'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='coapp_sex'>" . $row['coapp_sex'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='income'>" . $row['income'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='purchaser_type'>" . $row['purchaser_type'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='denial_reason1'>" . $row['denial_reason1'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='denial_reason2'>" . $row['denial_reason2'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='denial_reason3'>" . $row['denial_reason3'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='spread'>" . $spread . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='hoepa'>" . $row['hoepa'] . "</span></td>
		<td class='changeable incomplete'><span class='original-value' data-col='lien'>" . $row['lien'] . "</span></td>
		<td class='text-nowrap incomplete'>" . $row['created_by'] . "</td>
		<td class='text-nowrap incomplete'>" . $row['added'] . "</td>
		<td class='text-nowrap incomplete'>" . $row['edited_by'] . "</td>
		<td class='text- incomplete'>" . $row['last_edited'] . "</td>
		<td class='incomplete'><button type='button' class='btn btn-danger delete-row glyphicon glyphicon-trash' onClick='deleteRow(this)'></button></td>
		</tr>";
	}


	echo "</table></div><br><br><div align='center'><a href='/hmda.html'>Back</a></div><br><br>";
	
	$result->free();
?>

<script>
function deleteRow(thisElem) {
	if(confirm("Are you sure you wish to delete this row?")) {
	thisContent = thisElem;
	thisCell = thisContent.parentNode;
	var isIncomplete = $(thisCell).hasClass("incomplete");
	thisRow = thisCell.parentNode;
	accountToDelete = thisRow.cells[6].childNodes[0].innerHTML;
	$.ajax({
    			type: "POST",
    			url: "hmda-delete.php",
    			data: {	account: accountToDelete,
						incomplete: isIncomplete },
    			dataType: "text",
    			cache: false,
    			success: function(data) {
					if(data==="success") {
						delSuccess(thisRow);
					} else {
						alert(data);
					}
    			}

    		});
	}
}
function delSuccess(row) {
	$(row).children().hide('slow');
	setTimeout(function() {
		$(row).remove();
	}, 1000);
}
</script>
<script>
function toggleStar(button) {
	thisContent = button;
	thisCell = thisContent.parentNode;
	thisRow = thisCell.parentNode;
	if($(button).hasClass("btn-default")) {
		$(button).parent().append("<button type='button' class='btn btn-warning glyphicon glyphicon-star' onClick='toggleStar(this)'></button>");
		$(button).remove();
		updateStar(false, thisRow);
	} else {
		$(button).parent().append("<button type='button' class='btn btn-default glyphicon glyphicon-star-empty' onClick='toggleStar(this)'></button>");
		$(button).remove();
		updateStar(true, thisRow);
	}
}
function changeRow(thisElem) {
	thisContent = thisElem;
	thisCell = thisContent.parentNode;
	thisRow = thisCell.parentNode;
	accountToDelete = thisRow.cells[5].innerHTML;
	$(thisRow).children(".changeable").each(function() {
		var currentValue = $(this).children(".original-value:first").html();
		$(this).children(".original-value:first").hide();
		var columnName = $(this).children(".original-value:first").data("col");
		$(this).append("<input type='text' name='" + columnName + "'></input>");
		$(this).children("input:first").val(currentValue);
	});
	var changeButton = $(thisRow).children(".change-col");
	$(changeButton).html("<button type='button' class='btn btn-xs btn-success save-changes glyphicon glyphicon-ok' onClick='submitChange(this)'></button><button type='button' class='btn btn-xs btn-danger discard-changes glyphicon glyphicon-remove' onClick='discardChange(this)'></button>");
	
	
}
function submitChange(button) {
	thisContent = button;
	thisCell = thisContent.parentNode;
	var isIncomplete = $(thisCell).hasClass("incomplete");
	thisRow = thisCell.parentNode;
	var userName = getUserName();
	var dataObj = new Object();
	$(thisRow).find("input").each(function() {
		dataObj[$(this).attr("name")] = $(this).val();
	});
	dataObj["orig_number"] = $(thisRow).find(".original-value[data-col='loan_number']:first").html();
	dataObj["edited_by"] = userName;
	dataObj["incomplete"] = isIncomplete;
	$.ajax({
			type: "POST",
			url: "/php/hmda-update.php",
			data: dataObj,
			dataType: "text",
			cache: false,
			success: function(data) {
				if(data.indexOf("success")) {
					alert(data);
					changeSuccess(thisRow);
				} else {
					alert(data);
				}
			}

		});
}
function updateStar(add, row) {
	var dataObj = new Object();
	dataObj["checked"] = add;
	dataObj["loan_number"] = $(row).find(".original-value[data-col='loan_number']:first").html();
	dataObj["incomplete"] = $(row).find(".original-value[data-col='loan_number']:first").hasClass("incomplete");
	$.ajax({
			type: "POST",
			url: "/php/hmda-update-star.php",
			data: dataObj,
			dataType: "text",
			cache: false,
			success: function(data) {
				//silent
			}

		});
}
function discardChange(button) {
	thisContent = button;
	thisCell = thisContent.parentNode;
	thisRow = thisCell.parentNode;
	accountToDelete = thisRow.cells[5].innerHTML;
	$(thisRow).children(".changeable").each(function() {
		$(this).children(".original-value:first").show();
		$(this).children("input:first").remove();
	});
	$(thisRow).find(".discard-changes:first").remove();
	$(thisRow).find(".save-changes:first").remove();
	$(thisRow).children(".change-col:first").append("<button type='button' class='btn btn-info change-row glyphicon glyphicon-pencil' onClick='changeRow(this)'></button>");
}
function changeSuccess(row) {
	$(thisRow).children(".changeable").each(function() {
		$(this).children(".original-value:first").html($(this).children("input:first").val());
		$(this).children(".original-value:first").show();
		$(this).children("input:first").remove();
	});
	$(thisRow).find(".discard-changes:first").remove();
	$(thisRow).find(".save-changes:first").remove();
	$(thisRow).children(".change-col:first").append("<button type='button' class='btn btn-info change-row glyphicon glyphicon-pencil' onClick='changeRow(this)'></button>");
}
</script>

</body>
</html> 