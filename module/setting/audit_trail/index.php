<style>
	table {
		border-collapse: collapse;
		width: 100% !important;
		/* border: 1px solid black; */
	}

	th, td {
		/* border: 1px solid black; */
		padding: 8px;
		text-align: center;
	}

	/* Alternating Row Colors */
	#tbl-audit-trail tbody tr:nth-child(even) {
		background-color: #f0f0f0;
	}

	.control-bar {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.date-range-container, .date-container {
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.button-container {
		display: flex;
	}

	label {
		min-width: 50px;
		text-align: right;
	}
</style>

<main>
	<div class="card shadow rounded">
		<div class="card-header" style="background:white;">
			<div class="row">
				<div class="col-6">
					<h4>Audit Trail</h4>
				</div>
				<div class="col-6">
					<div class="float-right">
						<button type="button" class="btn btn-secondary" onclick="history.back();">Back</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body" style="overflow-y:auto;">
			<div class="control-bar mb-3">
				<div class="date-range-container">
					<div class="date-container">
						<label for="start-date" class="mr-3">From: </label>
						<div class="input-group date" id="start-date-picker" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input" data-target="#start-date-picker" id="start-date" name="start-date" value=""/>
							<div class="input-group-append" data-target="#start-date-picker" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
					<div class="date-container ml-1">
						<label for="end-date" class="mr-3">To: </label>
						<div class="input-group date" id="end-date-picker" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input" data-target="#end-date-picker" id="end-date" name="end-date" value=""/>
							<div class="input-group-append" data-target="#end-date-picker" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
					<button type="button" class="btn btn-primary ml-3" onclick="search();">Search</button>
					<button type="button" class="btn btn-secondary ml-1" onclick="reset();">Reset</button>
				</div>
			</div>
			<table id="tbl-audit-trail">
				<thead>
					<tr>
						<th>No.</th>
						<th>DateTime</th>
						<th>User</th>
						<th>User Group</th>
						<th>Module</th>
						<th>Submodule</th>
						<th>Action</th>
						<th>Remark</th>
						<th>Old Data</th>
						<th>New Data</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</main>

<script>
	var table;

    $(document).ready(function () {
		$('#start-date-picker').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#end-date-picker').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false
        });

        $("#start-date-picker").on("change.datetimepicker", function (e) {
            $('#end-date-picker').datetimepicker('minDate', e.date);
        });

        $("#end-date-picker").on("change.datetimepicker", function (e) {
            $('#start-date-picker').datetimepicker('maxDate', e.date);
        });

		// Fetch data using AJAX
		table = $('#tbl-audit-trail').DataTable({
			"ajax": {
				url: 'module/setting/audit_trail/get_audit_trail_ajax.php',
				type: 'GET'
			},
			"columns": [
				{
					data: null,
					render: function (data, type, row, meta) {
						// This column will contain the row numbers
						// "meta.row" contains the row index
						return meta.row + 1;
					}
				},
				{ data: 'datetime' },
				{ data: 'name' },
				{ data: 'user_group' },
				{ data: 'module_display_name' },
				{ data: 'submodule_display_name' },
				{ data: 'action' },
				{ data: 'remark' },
				{ data: 'old_data' },
				{ data: 'new_data' }
			],
			"columnDefs": [{ "targets": "_all", "orderable": false }],
			"serverSide": true,
			"paging": true, // Enable pagination
			"lengthChange": false, // Hide the length menu
		});
    });

	function search() {
		let from = $('#start-date').val();
		let to = $('#end-date').val();

		let param = '';

		if (from != '' && to == '') {
			param = `?from=${from}`;
		} else if (from == '' && to != '') {
			param = `?to=${to}`;
		} else if (from != '' && to != '') {
			param = `?from=${from}&to=${to}`;
		}

		// Reload data with parameters
		table.ajax.url(`module/setting/audit_trail/get_audit_trail_ajax.php${param}`).load();
	}

	function reset() {
		// Reset datetimepickers and table data
		$('#start-date').val('');
		$('#end-date').val('');
		table.ajax.url('module/setting/audit_trail/get_audit_trail_ajax.php').load();
	}
</script>