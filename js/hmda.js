$(document).ready(function() {
	if($("#coapp-check").is(":checked")) {
		$(".coapp-input").prop('disabled', false);
	}
	if ($(this).is(':checked')) {
		$(".denial-input").prop('disabled', false);
	}
	$('#coapp-check').click(function() {
		if ($(this).is(':checked')) {
			$(".coapp-input").prop('disabled', false);
		} else {
			$(".coapp-input").prop('disabled', true);
		}
	});
	$('#denial-check').click(function() {
		if ($(this).is(':checked')) {
			$(".denial-input").prop('disabled', false);
		} else {
			$(".denial-input").prop('disabled', true);
		}
	});
	$("#submit").click(validateForm);
	$(".form-control").blur(function(e) {
		if($(e.target).hasClass("no-val")) {
			var isGood = validateSelect(e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).closest(".form-group").children(".help-block").length<1) {
					$(e.target).closest(".form-group").append('<span class="help-block">A selection is required.</span>');
				}
			}
		} else if ($(e.target).hasClass("dateNotNull-val")) {
			var isGood = validateDateNotNull(e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(this);
				if($(e.target).closest(".form-group").children(".help-block").length<1) {
					$(e.target).closest(".form-group").append('<span class="help-block">Must be valid date in YYYYMMDD format.</span>');
				}
			}
		} else if ($(e.target).hasClass("dateWithNull-val")) {
			var isGood = validateDateWithNull(e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(this);
				if($(e.target).closest(".form-group").children(".help-block").length<1) {
					$(e.target).closest(".form-group").append('<span class="help-block">Must be valid date in YYYYMMDD format.</span>');
				}
			}
		} else if ($(e.target).is('#app_lname')) {
			var isGood = validateString(50, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">Name must be between 1 and 50 characters.</span>');
				}
			}
		} else if ($(e.target).is('#app_fname')) {
			var isGood = validateSelect(e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">Name must be between 1 and 50 characters.</span>');
				}
			}
		} else if ($(e.target).is('#amount')||$(e.target).is('#income')) {
			isGood = validateIntNotNull(1, 9999, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().parent().children(".help-block").length<1) {
					$(e.target).parent().parent().append('<span class="help-block">Amount must be between 1 and 9999. Remember to enter in thousands!</span>');
				}
			}
		} else if ($(e.target).is('#coapp_fname')||$(e.target).is('#coapp_lname')) {
			var isGood = validateString(50, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">Name must be between 1 and 50 characters.</span>');
				}
			}
		} else if ($(e.target).is('#msa')) {
			var isGood = validateIntWithNA(1, 99999, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">MSA must be at most 5 numbers (or "NA").</span>');
				}
			}
		} else if ($(e.target).is('#state')) {
			var isGood = validateIntWithNA(1, 99, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">State code must be at most 2 numbers (or "NA").</span>');
				}
			}
		} else if ($(e.target).is('#county')) {
			var isGood = validateIntWithNA(1, 999, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">County code must be at most 3 numbers (or "NA").</span>');
				}
			}
		} else if ($(e.target).is('#census')) {
			var isGood = validateString(10, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">Census tract must be at most 10 digits (or "NA").</span>');
				}
			}
		} else if ($(e.target).is('#spread')) {
			var isGood = validateString(5, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).closest(".form-group").children(".help-block").length<1) {
					$(e.target).closest(".form-group").append('<span class="help-block">Spread must be at most 5 digits (or "NA").</span>');
				}
			}
		} else if ($(e.target).is('#loan_number')) {
			isGood = validateIntNotNull(1, 1000000000, e.target.value);
			if(isGood) {
				markSuccess(e.target);
			} else {
				markFailure(e.target);
				if($(e.target).parent().children(".help-block").length<1) {
					$(e.target).parent().append('<span class="help-block">Loan number must be numeric.</span>');
				}
			}
		}
	});
});

Number.isInteger = Number.isInteger || function(value) {
	return typeof value === "number" && 
		isFinite(value) && 
		Math.floor(value) === value;
};

function validateForm() {
	console.log($("#incomplete").prop("checked"));
	if($("#incomplete").prop("checked")===true) {
		if ($("#loan_number").val() == "") {
			alert("A loan or application number is required. This can be changed later.");
			return;
		}
		var userName = getUserName();
		var dataObj = new Object();
		$("#hmda-form :input").each(function() {
			dataObj[$(this).attr("name")] = $(this).val();
		});
		dataObj["created_by"] = userName;
		$.ajax({
    			type: "POST",
    			url: "/php/hmda.php",
    			data: dataObj,
    			dataType: "text",
    			cache: false,
    			success: function(data) {
					alert(data);
					document.getElementById("hmda-form").reset();
					$("input").closest(".form-group").removeClass("has-success");
					$("input").closest(".form-group").children(".glyphicon").remove();
					$("select").closest(".form-group").removeClass("has-success");
					$("select").closest(".form-group").children(".glyphicon").remove();
    			}

    		});
		return;
	}
	var okayToSubmit = true;
	$(".no-val").each(function() {
		var isGood = validateSelect(this.value);
		if(isGood) {
			markSuccess(this);
		} else {
			okayToSubmit = false;
			markFailure(this);
			if($(this).closest(".form-group").children(".help-block").length<1) {
				$(this).closest(".form-group").append('<span class="help-block">A selection is required.</span>');
			}
		}
	});
	$(".dateNotNull-val").each(function() {
		var isGood = validateDateNotNull(this.value);
		if(isGood) {
			markSuccess(this);
		} else {
			okayToSubmit = false;
			markFailure(this);
			if($(this).closest(".form-group").children(".help-block").length<1) {
				$(this).closest(".form-group").append('<span class="help-block">Must be valid date in YYYYMMDD format.</span>');
			}
		}
	});
	$(".dateWithNull-val").each(function() {
		var isGood = validateDateWithNull(this.value);
		if(isGood) {
			markSuccess(this);
		} else {
			okayToSubmit = false;
			markFailure(this);
			if($(this).closest(".form-group").children(".help-block").length<1) {
				$(this).closest(".form-group").append('<span class="help-block">Must be valid date in YYYYMMDD format.</span>');
			}
		}
	});
	$("#app_lname").each(function() {
		var isGood = validateString(50, this.value);
		if(isGood) {
			markSuccess(this);
		} else {
			okayToSubmit = false;
			markFailure(this);
			if($(this).parent().children(".help-block").length<1) {
				$(this).parent().append('<span class="help-block">Name must be between 1 and 50 characters.</span>');
			}
		}
	});


	if($("#coapp-check")[0].checked) {
		$("#coapp_fname, #coapp_lname").each(function() {
		var isGood = validateString(50, this.value);
		if(isGood) {
			markSuccess(this);
		} else {
			okayToSubmit = false;
			markFailure(this);
			if($(this).parent().children(".help-block").length<1) {
				$(this).parent().append('<span class="help-block">Name must be between 1 and 50 characters.</span>');
			}
		}
	});
	} else {
		$("#coapp_fname").val("NA");
		markSuccess($("#coapp_fname")[0]);
		$("#coapp_lname").val("NA");
		markSuccess($("#coapp_lname")[0]);
	}
	var loanNumber = $("#loan_number")[0];
	isGood = validateIntNotNull(1, 1000000000, loanNumber.value);
	if(isGood) {
		markSuccess(loanNumber);
	} else {
		okayToSubmit = false;
		markFailure(loanNumber);
		if($(loanNumber).parent().children(".help-block").length<1) {
			$(loanNumber).parent().append('<span class="help-block">Loan number must be numeric.</span>');
		}
	}
	$("#amount, #income").each(function() {
		isGood = validateIntNotNull(1, 9999, this.value);
		if(isGood) {
			markSuccess(this);
		} else {
			okayToSubmit = false;
			markFailure(this);
			if($(this).parent().parent().children(".help-block").length<1) {
				$(this).parent().parent().append('<span class="help-block">Amount must be between 1 and 9999. Remember to enter in thousands!</span>');
			}
		}
	});	
	var msa = $("#msa")[0];
	isGood = validateIntWithNA(1, 99999, msa.value);
	if(isGood) {
		markSuccess(msa);
	} else {
		okayToSubmit = false;
		markFailure(msa);
		if($(msa).parent().children(".help-block").length<1) {
			$(msa).parent().append('<span class="help-block">MSA must be at most 5 numbers (or "NA").</span>');
		}
	}
	var state = $("#state")[0];
	isGood = validateIntWithNA(1, 99, state.value);
	if(isGood) {
		markSuccess(state);
	} else {
		okayToSubmit = false;
		markFailure(state);
		if($(state).parent().children(".help-block").length<1) {
			$(state).parent().append('<span class="help-block">State code must be at most 2 numbers (or "NA").</span>');
		}
	}
	var county = $("#county")[0];
	isGood = validateIntWithNA(1, 999, county.value);
	if(isGood) {
		markSuccess(county);
	} else {
		okayToSubmit = false;
		markFailure(county);
		if($(county).parent().children(".help-block").length<1) {
			$(county).parent().append('<span class="help-block">County code must be at most 3 numbers (or "NA").</span>');
		}
	}
	var census = $("#census")[0];
	isGood = validateString(10, census.value);
	if(isGood) {
		markSuccess(census);
	} else {
		okayToSubmit = false;
		markFailure(census);
		if($(census).parent().children(".help-block").length<1) {
			$(census).parent().append('<span class="help-block">Census code must be at most 10 digits (or "NA").</span>');
		}
	}
	var spread = $("#spread")[0];
	isGood = validateString(5, spread.value);
	if(isGood) {
		markSuccess(spread);
	} else {
		okayToSubmit = false;
		markFailure(spread);
		if($(spread).parent().parent().children(".help-block").length<1) {
			$(spread).parent().parent().append('<span class="help-block">Rate spread must be at most 5 digits (or "NA").</span>');
		}
	}
	if(okayToSubmit) {
		var userName = getUserName();
		var dataObj = new Object();
		$("#hmda-form :input").each(function() {
			dataObj[$(this).attr("name")] = $(this).val();
		});
		dataObj["created_by"] = userName;
		dataObj["incomplete"] = "";
		$.ajax({
    			type: "POST",
    			url: "/php/hmda.php",
    			data: dataObj,
    			dataType: "text",
    			cache: false,
    			success: function(data) {
					alert(data);
					document.getElementById("hmda-form").reset();
					$("input").closest(".form-group").removeClass("has-success");
					$("input").closest(".form-group").children(".glyphicon").remove();
					$("select").closest(".form-group").removeClass("has-success");
					$("select").closest(".form-group").children(".glyphicon").remove();
    			}

    		});
	}
}

function validateSelect(input) {
	if(input==="null") {
		return false;
	} else {
		return true;
	}
}

function validateIntWithNA(min, max, input) {
	if(input==="NA") {
		return true;
	}
	input = Number(input);
	if(isNaN(input)) {
		return false;
	}
	if(input<min||input>max) {
		return false;
	}
	if(Number.isInteger(input)) {
		return true;
	}
	return false;
}

function validateIntWithBlank(min, max, input) {
	if(input==="") {
		return true;
	}
	input = Number(input);
	if(isNaN(input)) {
		return false;
	}
	if(input<min||input>max) {
		return false;
	}
	if(Number.isInteger(input)) {
		return true;
	}
	return false;
}

function validateIntNotNull(min, max, input) {
	input = Number(input);
	if(isNaN(input)) {
		return false;
	}
	if(input<min||input>max) {
		return false;
	}
	if(Number.isInteger(input)) {
		return true;
	}
	return false;
}

function validateDateWithNull(input) {
	if(input==="NA") {
		return true;
	}
	if(input.length!==8) {
		return false;
	}
	var numberTest = Number(input);
	if(isNaN(numberTest)) {
		return false;
	}
	if(!Number.isInteger(numberTest)) {
		return false;
	}
	var year = Number(input.substring(0,4));
	var month = Number(input.substring(4,6));
	var day = Number(input.substring(6,8));
	if(year<2016||year>2030) {
		return false;
	}
	if(month<1||month>12) {
		return false;
	}
	if(day<1||day>31) {
		return false;
	}
	if(month===2&&day>29) {
		return false;
	}
	return true;
}

function validateDateNotNull(input) {
	if(input.length!==8) {
		return false;
	}
	var numberTest = Number(input);
	if(isNaN(numberTest)) {
		return false;
	}
	if(!Number.isInteger(numberTest)) {
		return false;
	}
	var year = Number(input.substring(0,4));
	var month = Number(input.substring(4,6));
	var day = Number(input.substring(6,8));
	if(year<2016||year>2030) {
		return false;
	}
	if(month<1||month>12) {
		return false;
	}
	if(day<1||day>31) {
		return false;
	}
	if(month===2&&day>29) {
		return false;
	}
	return true;
}

function validateString(max, input) {
	if(input.length<1||input.length>max) {
		return false;
	}
	return true;
}

function markSuccess(e) {
	$(e).closest(".form-group").removeClass("has-error");
	$(e).closest(".form-group").addClass("has-success");
	$(e).closest(".form-group").children(".glyphicon-remove").remove();
	$(e).closest(".form-group").append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
	$(e).closest(".form-group").children(".help-block").remove();

}

function markFailure(e) {
	$(e).closest(".form-group").removeClass("has-success");
	window.setTimeout(function() {
		$(e).closest(".form-group").removeClass("shake");
	}, 1000);
	$(e).closest(".form-group").addClass("has-error");
	$(e).closest(".form-group").addClass("shake");
	$(e).closest(".form-group").children(".glyphicon-ok").remove();
	$(e).closest(".form-group").append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
}