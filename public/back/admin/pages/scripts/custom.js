$('.date-picker-month').datepicker({
	   	    format: 'mm-yyyy',
	   	    // startView: 1,
	   	    // minViewMode: 1
	   	});

	   	$('.date-picker-year').datepicker({
	   	    format: 'yyyy',
	   	    // startView: 2,
	   	    // minViewMode: 2
	   	});

	   	$('.date-picker').datepicker({
	   	    format: 'dd-mm-yyyy',
	   	    // startView: 2,
	   	    // minViewMode: 2
	   	});

	   	var regexlink = new RegExp("^[-_a-zA-Z0-9\b]+$");
	   	$('.link').bind("keypress", function (event) {
	   	    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	   	    if (!regexlink.test(key)) {
	   	        event.preventDefault();
	   	        return false;
	   	    }
	   	});

	   	var regexemail = new RegExp("^[-_a-zA-Z0-9\b@.]+$");
	   	$('.email').bind("keypress", function (event) {
	   	    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	   	    if (!regexemail.test(key)) {
	   	        event.preventDefault();
	   	        return false;
	   	    }
	   	});

	   	var regexnumb = new RegExp("^[0-9\b]+$");
	   	$('.number').bind("keypress", function (event) {
	   	    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	   	    if (!regexnumb.test(key)) {
	   	        event.preventDefault();
	   	        return false;
	   	    }
	   	});