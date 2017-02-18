var FormValidation = function () {

	var handleLogin = function(form_target, rule, message, title, text) {

		title = (typeof title === "undefined") ? "Are You Sure?" : title;
    	text = (typeof text === "undefined") ? "?" : text;

		// var form_input   = $(form_target);
		// var form_action  = form_input.attr('action');
		// var form_confirm = form_input.attr('data-confirm');
		// var error        = $('.alert-danger', form_input);
		// var warning      = $('alert-warning', form_input);
		// var data         = '';

		$('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: rule,
            messages: message,

            invalidHandler: function (event, validator) { //display error alert on form submit   
                error.show();
                Metronic.scrollTo(error, -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit();
                }
                return false;
            }
        });
	}
    
    return {
        //main function to initiate the module
        init: function (form_target, rule, message, title, text) { 
        	handleLogin(form_target, rule, message, title, text); 
    	},
        initDefault: function (form_target, rule, message, title, text) {
            $('.select2').select2('destroy');
            $('.select2').select2();

            title = (typeof title === "undefined") ? "Are You Sure?" : title;
            text = (typeof text === "undefined") ? "?" : text;
            
            var form_input = $(form_target);
            var form_action = form_input.attr('action');
            var form_confirm = form_input.attr('data-confirm');
            var error = $('.alert-danger', form_input);
            var warning = $('.alert-warning', form_input);
            var data = '';

            form_input.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: message,
                rules: rule,

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    error.show();
                    Metronic.scrollTo(error, -200);
                    if ($('#summernote').length > 0) {
                        $('#summernote').summernote({height: 300});
                    }
                },

                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    if(form_confirm == 1){
                        swal({
                            title: title,
                            text: text,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Yes',
                            closeOnConfirm: true,
                        },
                        function(){
                            Metronic.blockUI({
                                target: form_target,
                                animate: true
                            });

                            var options = { 
                                dataType:      'json',
                                success:       callback_form,
                                error:         callback_error
                            }; 

                            $(form).ajaxSubmit(options);
                        });
                    }else{
                        Metronic.blockUI({
                            target: form_target,
                            animate: true
                        });

                        var options = { 
                            dataType:      'json',
                            success:       callback_form,
                            error:         callback_error
                        }; 

                        $(form).ajaxSubmit(options);
                    }
                }
            });

            function callback_form(res, statusText, xhr, $form)
            {
                if(res.status == 1){
                    warning.hide();

                    toastr.options = call_toastr('4000');
                    var $toast = toastr['success'](res.message, "Success");

                    if($('.reload').length)
                    {
                        $('.reload').trigger('click');
                    }

                }else if(res.status == 0 || res.status == 2){
                    warning.hide();

                    toastr.options = call_toastr('4000');
                    var $toast = toastr['error'](res.message, "Error");
                }else{
                    warning.find('span').html(res.message);
                    warning.show();
                    Metronic.scrollTo(warning, -200);
                }

                Metronic.unblockUI(form_target);
            }

            function callback_error(){
                toastr.options = call_toastr('4000');
                var $toast = toastr['error']('Something wrong!', "Error");

                Metronic.unblockUI(form_target);
            }
        }
    };

}();