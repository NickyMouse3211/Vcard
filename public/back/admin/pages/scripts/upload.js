var Upload = function () {

    return {
        //main function to initiate the module
        handleUploadExcel : function(url) {
        	$('#click_upload').click(function(){
				$('#file').trigger('click');
			});

		    $("#file").change(function() {
	            var fd = new FormData();
	            fd.append('file', this.files[0]);

				$.ajax({
		        	url: url,
					type: "POST",
					data: fd,
					contentType: false,
		    	    cache: false,
					processData: false,
					dataType: 'json',
					success: function(data){
                        $('#file').val('');

                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "1000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };

                        if(data.status == 0){
                        	var war = 'error';
                        }else if(data.status == 1){
                        	var war = 'success';
                        }

                        var toast = toastr[war](data.message, war.charAt(0).toUpperCase() + war.slice(1));
                        gridT.getDataTable().ajax.reload();
				    },
				    error : function(msg){
                        $('#file').val('');
				    }
			   	});
		    });
        }
        
    };

}();