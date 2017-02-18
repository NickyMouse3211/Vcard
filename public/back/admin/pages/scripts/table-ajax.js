var TableAjax = function () {
    return {

        //main function to initiate the module
        initDefault: function (url, header, order, sort) {
            var grid = new Datatable();

            grid.init({
                src: $("#datatable_ajax"),
                onSuccess: function (grid) {
                    // execute some code after table records loaded
                },
                onError: function (grid) {
                    // execute some code on network or other general error  
                },
                onDataLoad: function(grid) {
                    // execute some code on ajax data load
                    $('.tooltips').tooltip();
                },
                dataTable: { 
                    "aoColumns": header,
                    "pageLength": 20,
                    "lengthMenu": [
                        [10, 20, 50, 100, 150, -1],
                        [10, 20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "ajax": {
                        "url": url,
                    },
                    "aoColumnDefs": [
                      { "bSortable": false, "aTargets": sort }
                    ],
                    "order": order
                }
            });

            grid.getTableWrapper().on('keyup', '.form-filter', function (e) {
                if(e.keyCode == 13){
                    $('.filter-submit').trigger('click');
                }
            });

            grid.getTableWrapper().on('change', '.select-filter', function (e) {
                $('.filter-submit').trigger('click');
            });

            // handle group actionsubmit button click
            grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                e.preventDefault();
                var action = $(".table-group-action-input", grid.getTableWrapper());
                if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                    var message = 'Default Message';
                    var message_success = 'Default Success Message';

                    if(action.val() == 'InActive'){
                        message = 'Are you sure want to InActive Data ?';
                        message_success = 'Your data has successfully InActive ?';
                    }else if(action.val() == 'Active'){
                        message = 'Are you sure want to Activate Data ?';
                        message_success = 'Your data has successfully Activate ?';
                    }else if(action.val() == 'Delete'){
                        message = 'Are you sure want to Delete Data ?';
                        message_success = 'Your data has successfully Delete ?';
                    }

                    swal({
                        title: "Are you sure?",
                        text: message,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Yes',
                        closeOnConfirm: false,
                    },
                    function(){
                        grid.setAjaxParam("customActionType", "group_action");
                        grid.setAjaxParam("customActionName", action.val());
                        grid.setAjaxParam("id", grid.getSelectedRows());
                        grid.getDataTable().ajax.reload();
                        grid.clearAjaxParams();
                        swal("Success", message_success, "success");
                    });
                } else if (action.val() == "") {
                    Metronic.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: 'Please select an action',
                        container: grid.getTableWrapper(),
                        place: 'prepend'
                    });
                } else if (grid.getSelectedRowsCount() === 0) {
                    Metronic.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: 'No record selected',
                        container: grid.getTableWrapper(),
                        place: 'prepend'
                    });
                }
            });

            gridT = grid;
        }

    };

}();