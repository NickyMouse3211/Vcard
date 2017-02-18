var ng = {
	reference : {
		id : ''
	},
	formProcess : function(Obj, act, redirect, callback, callbackoption, isCloseModal) {
		this.stopSubmitOnPressEnter(Obj);
		//callback handler for form submit
		switch (act) {
		case 'delete':
			msg = {
				success : 'Data Berhasil Dihapus!',
				error : 'Data Gagal Dihapus!'
			};
			break;
        case 'reset_password':
            msg = {
                success : 'Password baru berhasil dikirim !',
                error : 'Data Gagal Dihapus!'
            };
                break;
		default:
			msg = {
				success : 'Data Berhasil Disimpan!',
				error : 'Data Gagal Disimpan!'
			};
		}
		$(Obj).submit(function(e) {
			var formObj = $(this);
			var formURL = formObj.attr("action");
			var formData = new FormData(this);
            if (isCloseModal == false) {
            } else {
                CloseModalBox();
            }
            $('#loader_area').show();
            $('button').attr('disabled','disabled');
			$.ajax({
				url : formURL,
				type : 'POST',
				data : formData,
				mimeType : "multipart/form-data",
				contentType : false,
				cache : false,
				processData : false,
				success : function(data, textStatus, jqXHR) {
                    $('button').removeAttr('disabled');
                    $('#loader_area').hide();

					if (data == 0) {
						alertify.error(msg.error);
					} else {
						alertify.success(msg.success);
					}
					if (typeof callback === "function") {
						callback(callbackoption);
					}
					if (redirect) {
						var url = redirect;
						window.location.hash = url;
						ng.LoadAjaxContent(url);
						return false;
					}
					// alert(data);
					ng.reference.id = data;
				},
				error : function(jqXHR, textStatus, errorThrown) {
                    $('button').removeAttr('disabled');
                    $('#loader_area').hide();
					alertify.error(msg.error + "\n" + jqXHR.statusText);
				}
			});
			e.preventDefault(); //Prevent Default action.
			// e.unbind();
		});
		if (act == 'insert') { // Ctrl + s
			$(document).on('keydown', function(e) {
				if (e.ctrlKey && e.which === 83) {
					e.preventDefault();
					$(Obj).submit();
					return false;
				}
			});
		} else if (act == 'update') {
			$(document).on('keydown', function(e) {
				if (e.ctrlKey && e.which === 83) {
					e.preventDefault();
					$(Obj).submit();
					return false;
				}
			});
		}
	},
	LoadAjaxContentPost : function(url, form, target, callback, callbackoption) {
		$('#loader_area').show();
		$.post(url, form.serialize(), function(html) {
            $('#loader_area').hide();
			if (target) {
				$(target).html(html);
			} else {
				$('#test').html(html);
			}
			// $('.preloader').hide();
			if (typeof callback === "function") {
				callback(callbackoption);
			}
			$('.breadcrumb a').click(function(e) {
				e.preventDefault(); //Prevent Default action.
				// e.unbind();            
				url = $(this).attr('href');
				window.location.hash = url;
				ng.LoadAjaxContent(url);
				return false;
			});
			return false;
		});
	},
	LoadAjaxContent : function(url, target) {
		// $('.preloader').show();
		// url = $(this).attr('href');
		// window.location.hash = location;
        $('#loader_area').show();
		$.ajax({
			mimeType : 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url : url,
			type : 'GET',
			success : function(html) {
                $('#loader_area').hide();
				if (target) {
					$(target).html(html);
				} else {
					$('#test').html(html);
				}
				// $('.preloader').hide();
				$('.breadcrumb a').click(function(e) {
					e.preventDefault(); //Prevent Default action.
					url = $(this).attr('href');
					// window.location.hash = location;
					ng.LoadAjaxContent(url);
					// e.unbind();             
					return false;
				});
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alertify.alert(textStatus, errorThrown);
				$('#loader_area').hide();
			},
			dataType : "html",
			async : false
		});
	},
	stopSubmitOnPressEnter : function(Obj) {
		$(Obj).find(":input").keypress(function(e) {
			var code = e.keyCode || e.which;
			var src = e.srcElement || e.target;
			if (src.tagName.toLowerCase() != "textarea") {
				if (code == 13) {
					if (e.preventDefault) {
						e.preventDefault();
					} else {
						e.returnValue = false;
					}
					e.preventDefault();
					return false;
				}
			}
		});
	},
	LoadAjaxTabContent : function(opt) {
		$(opt.block).block({
			message : '<img src="images/loading.gif" width="100px" />'
		});
		$.get(opt.url, function(html) {
			$(opt.container).html(html);
			$(opt.block).unblock();
		});
	},
	exportTo : function(mode, action, title) { // author gunaones
		$('#ajaxFormCari').after(
				'<form method="post" action="' + action
						+ '" id="ajaxFormPrint"></form>');
		$("#ajaxFormCari").children().clone().appendTo('#ajaxFormPrint');
		if (mode == 'pdf') {
			html = '<iframe src="" width="100%" height="'
					+ ($(window).height() - 140 + 'px')
					+ '" style="border:1px solid #cfcfcf;" name="iframeCetak"></iframe>';
			OpenModalBox(title, html, '', 'large');
			$('#ajaxFormPrint').attr('target', 'iframeCetak');
		} else if (mode == 'excel') {
			$('#ajaxFormPrint').removeAttr('target');
		} else if (mode == 'word') {
			$('#ajaxFormPrint').removeAttr('target');
		}
		$('#ajaxFormPrint').submit();
		$('#ajaxFormPrint').remove();
	},
	postOpenModalBox : function(url, title, footer, size){
        $.post(url, function (html) {
            OpenModalBox(title, html, footer, size);
        }); 
    },
    setRequired : function(objRequired){
        $.each(objRequired, function(index, val) {
             if(val[1]){
                $(val[0]).prop('required', true);
             }else{
                $(val[0]).prop('required', false);
             }
        });
    }
}