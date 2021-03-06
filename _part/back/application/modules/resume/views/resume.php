<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Table <?=$pagetitle?></span>
		</div>
		<div class="actions">
			<!--a href="javascript:;" id="click_upload" class="btn purple-plum tooltips" data-original-title="Import Data"><i class="fa fa-file-excel-o"></i></a>
			<a data-toggle="modal" href="#export" id="click_export" class="btn yellow tooltips" data-original-title="Export Data"><i class="fa fa-file-excel-o"></i></a-->
			<a href="<?=base_url($instance.'/show_add')?>" class="ajaxify btn green-meadow tooltips" data-original-title="Add <?=$pagetitle?> Data"><i class="fa fa-plus"></i></a>
			<span style="display: inline;" class="help-block"></span>
			<a href="javascript:;" id="find" class="btn blue-madison tooltips" data-original-title="Find"><i class="fa fa-search"></i></a>
			<span style="display: inline;" class="help-block"></span>
			<a href="<?php echo base_url().$instance; ?>" class="btn blue-chambray tooltips ajaxify" data-original-title="Reload"><i class="fa fa-refresh"></i></a>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-container">
			<div class="table-actions-wrapper">
				<select data-style="btn-primary" class="banner-select table-group-action-input form-control input-inline input-small input-sm">
					<option value="">Select...</option>
					<option value="99">Delete</option>
					<option value="0">InActive</option>
					<option value="1">Active</option>
				</select>
				<button data-original-title="Submit" class="custom tooltips btn btn-sm btn-icon-only yellow table-group-action-submit"><i class="fa fa-check"></i></button>
			</div>
			<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
			<thead>
			<tr role="row" class="heading">
				<th width="30px">
					<input type="checkbox" class="group-checkable">
				</th>
				<th width="40px">
					 No
				</th>
				<th>
					 Name
				</th>
				<th>
					 Type
				</th>
				<th>
					 Position
				</th>
				<th>
					 Sub
				</th>
				<th>
					 Period
				</th>
				<th>
					 Status
				</th>
				<th>
					 Last Update
				</th>
				<th width="180px">
					 Actions
				</th>
			</tr>
			<tr role="row" class="filter display-hide">
				<td></td>
				<td></td>
				<td>
					<input type="text" class="form-control form-filter input-sm" placeholder="name" name="name">
				</td>
				<td>
					<select class="form-control form-filter input-sm" placeholder="type" name="type">
						<option value="employment">Employment</option>
						<option value="education">Education</option>
					</select>
				</td>
				<td>
					<input type="text" class="form-control form-filter input-sm" placeholder="position" name="position">
				</td>
				<td>
					<input type="text" class="form-control form-filter input-sm" placeholder="sub" name="sub">
				</td>
				<td>
					<input type="text" class="form-control form-filter input-sm" placeholder="period" name="period">
				</td>
				<td>
					<select name="status" class="select2 form-control form-filter select-filter input-sm">
						<option value="">Select...</option>
						<option value="99">Delete</option>
						<option value="0">InActive</option>
						<option value="1">Active</option>
					</select>
				</td>
				<td>
					<input type="text" class="form-control form-filter input-sm daterange" name="update_date">
				</td>
				<td class="text-center">
					<button data-original-title="Search" class="tooltips btn btn-sm yellow-crusta filter-submit margin-bottom"><i class="fa fa-search"></i></button>
					<button data-original-title="Reset" class="tooltips btn btn-sm red-sunglo filter-cancel"><i class="fa fa-times"></i></button>
				</td>
			</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">

	jQuery(document).ready(function() {
		var url = base_url+"resume/select";
		var header = [
			{ "sClass": "text-center" },
			{ "sClass": "text-center" },
			null,
			null,
			null,
			null,
			null,
			{ "sClass": "text-center" },
			{ "sClass": "text-center" },
			{ "sClass": "text-center" }
        ];
        var order = [
            [2, "asc"]
        ];

        var sort = [-1, 0, 1];

        $('.select2').select2();

	   	TableAjax.initDefault(url, header, order, sort);

	   	// $('#ROLE').select2({
	   	//     minimumInputLength: 0,
	   	//     ajax: {
	   	//         url: "<?=base_url('universal/get_role')?>",
	   	//         dataType: 'json',
	   	//         quietMillis: 250,
	   	//         data: function (term, page) {
	   	//             return {
	   	//                 q: term,
	   	//             };
	   	//         },
	   	//         results: function (data, page) {
	   	//             return { results: data.item };
	   	//         },
	   	//         cache: true
	   	//     },
	   	//     initSelection: function(element, callback) {
	   	//         var id = $(element).val();
	   	//         if (id !== "") {
	   	//             $.ajax("<?=base_url('universal/get_role')?>/"+id, {
	   	//                 dataType: "json"
	   	//             }).done(function(data) { callback(data[0]); });
	   	//         }
	   	//     },
	   	//     formatResult: function (state) {
	   	//         return state.name;
	   	//     },
	   	//     formatSelection:  function (state) {
	   	//         return state.name;
	   	//     }
	   	// });

	   	$('.banner-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
	});
	

</script>