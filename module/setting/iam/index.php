<?php
include_once 'include/db_connection.php';

if (isset($_GET['tab']))
{
	$tab = $_GET['tab'];
}
else
{
	$tab = false;
}

if ($tab == 'user-staff')
{
	$tab1 = '';
	$tab2 = 'active';
	echo "<script>openTab('".$tab."')</script>";
}
else
{
	$tab1 = 'active';
	$tab2 = '';
}

?>

<style>
	label {
		margin-bottom: 2px;
		width: 20%;
		margin-bottom: 0 !important;
	}

	/* Tab Styles */
	.tabs {
		display: flex;
		height: 5%;
		border-bottom: 1px solid #ccc;
	}

	.tab {
		padding: 10px 20px;
		cursor: pointer;
		border: 1px solid #ccc;
		border-bottom: none;
		border-radius: 5px 5px 0 0;
		background-color: #f5f5f5;
	}

	.tab.active {
		background-color: #e6ffe6;
		border-color: #ccc;
	}

	.tab-container-title {
		height: 5%;
	}

	.tab-content {
		display: flex;
		flex-direction: column;
		height: 90%;
		padding: 20px;
		border: 1px solid #ccc;
		border-radius: 0 0 5px 5px;
		background-color: white;
		/* overflow-y: auto; */
	}

	/* Table Styles */
	table {
		border-collapse: collapse;
		width: 100%;
		margin-bottom: 20px;
		border: 1px solid #ccc;
		font-family: Arial, sans-serif;
	}

	th, td {
		border: 1px solid #ccc;
		padding: 10px;
		text-align: center;
	}

	/* Header Styles */
	thead {
		background-color: #f5f5f5;
	}

	th {
		font-weight: bold;
	}

	/* Alternating Row Colors */
	tbody tr:nth-child(even) {
		background-color: #f0f0f0;
	}

	/* Hover Effect */
	tbody tr:hover {
		background-color: #e0e0e0;
	}

	/* Sticky Header */
	.sticky-header {
		position: sticky;
		top: 0;
		background-color: #f5f5f5;
		z-index: 1;
	}

	/* Scrollable Table Body */
	.table-container {
		flex: 1; /* Make the container grow to fill parent's height */
		overflow-y: auto;
	}

	/* Buttons */
	.control-button-container {
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}

	.user-group-dropdown {
		display: flex;
		justify-content: space-evenly;
		align-items: center;
		width: 50%;
	}

	.mb-5, .my-5 {
    	margin-bottom: 0rem!important;
	}

	/* .modal {
		background-color: beige;
	} */

	.action-button {
		cursor: pointer;
	}
</style>

<!-- Navigation -->
<div class="main">
	<div class="tab-container-title mb-5"><h2>User Management</h2></div>
	<div class="tabs">
		<div class="tab <?php echo $tab1 ?>" id="tab-user-group" onclick="openTab('user-group')">User Group</div>
		<div class="tab <?php echo $tab2 ?>" id="tab-user-staff" onclick="openTab('user-staff')">User Staff</div>
		<div class="tab" id="tab-module-access" onclick="openTab('module-access')">Module Access</div>
	</div>

	<!-- Tab 1: User Group -->
	<div class="tab-content" id="tab-content-user-group">
		<div class="control-button-container mb-3">
			<!-- <button type="button" class="btn btn-danger" onclick="history.back();">Back</button> -->
			<button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="" onclick="addUserGroup();">Add</button>
		</div>
		<div class="table-container">
			<table id="tbl-user-group">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>User Group</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 0;
						$sql = "SELECT * FROM aims_user_group WHERE status = 'ACTIVE' AND user_group_name != 'EXECUTIVE' AND id != '1'";
						$query = mysqli_query($con, $sql);
	
						while ($row = mysqli_fetch_assoc($query)) {
							$user_group_id = $row['id'];
							$user_group_name = $row['user_group_name'];
							$description = $row['description'];

							$sql_usergroupnumber = "SELECT * FROM aims_user WHERE user_group_id = '".$user_group_id."'";
							$result_usergroupnumber = mysqli_query($con, $sql_usergroupnumber);
							$usergroupnumber = mysqli_num_rows($result_usergroupnumber);
					?>
							<tr>
								<td><?php echo ++$count; ?></td>
								<td><?php echo $user_group_name; ?></td>
								<td><?php echo $description; ?></td>
								<td>
									<a title="More Info" data-toggle="modal" data-target="#userGroupModal" class="action-button mx-1 mr-1" onclick="viewUserGroup('<?php echo $user_group_id; ?>', '<?php echo $user_group_name; ?>', '<?php echo $description; ?>')">
										<img src="/aims/include/action/review.png">
									</a>
									<a title="Edit" data-toggle="modal" data-target="#userGroupModal" class="action-button mx-1 mr-1" onclick="editUserGroup('<?php echo $user_group_id; ?>', '<?php echo $user_group_name; ?>', '<?php echo $description; ?>')">
										<img src="/aims/include/action/edit.png">
									</a>
									<a title="Delete" data-toggle="modal" data-target="#userGroupModal" class="action-button mx-1" onclick="confirmDeleteUserGroup('<?php echo $user_group_id; ?>','<?php echo $usergroupnumber; ?>','<?php echo $user_group_name; ?>')">
										<img src="/aims/include/action/delete.png">
									</a>
								</td>
							</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Tab 2: User -->
	<div class="tab-content" id="tab-content-user-staff">
		<div class="control-button-container mb-3">
			<button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="" onclick="location.href='/aims/adduser'">Add</button>
		</div>
		<div class="table-container">
			<!-- <form>
				<input type="text" class="form-control mb-3" id="search" name="search" autofocus oninput = "filterUsername(this.value)" placeholder="Search Username">
			</form> -->
			<table id="tbl-user-staff">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>Username</th>
						<th>Email</th>
						<th>Full Name</th>
						<th>Department</th>
						<th>Position</th>
						<th>User Group</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 0;
						$sql = "SELECT * FROM aims_user WHERE status = 'ACTIVE' AND username != 'root'";
						$query = mysqli_query($con, $sql);
	
						while ($row = mysqli_fetch_assoc($query)) {
							$user_id = $row['id'];
							$user_username = $row['username'];
							$user_email = $row['email'];
							$user_fullname = $row['full_name'];
							$user_department = $row['department'];
							$user_position = $row['position'];

							$sql_usergroup = "SELECT * FROM aims_user_group WHERE id = '".$row['user_group_id']."'";
							$query_usergroup = mysqli_query($con, $sql_usergroup);
							$row_usergroup = mysqli_fetch_assoc($query_usergroup);
							if($row_usergroup)
							{
								$usergroup_name = $row_usergroup['user_group_name'];
							}
							else
							{
								$usergroup_name = '';
							}
					?>
							<tr>
								<td><?php echo ++$count; ?></td>
								<td><?php echo $user_username; ?></td>
								<td><?php echo $user_email; ?></td>
								<td><?php echo $user_fullname; ?></td>
								<td><?php echo $user_department; ?></td>
								<td><?php echo $user_position; ?></td>
								<td><?php echo $usergroup_name; ?></td>
								<td>
									<a title="More Info" class="action-button mx-1 mr-1" href="./viewuser?id=<?php echo $user_id; ?>">
										<img src="/aims/include/action/review.png">
									</a>
									<a title="Edit" class="action-button mx-1 mr-1" href="./edituser?id=<?php echo $user_id; ?>">
										<img src="/aims/include/action/edit.png">
									</a>
								<?php if ($usergroup_name != 'EXECUTIVE') { ?>
									<a title="Reset Password" class="action-button mx-1" onclick="confirmResetPasswordUser('<?php echo $user_id; ?>', '<?php echo $user_email; ?>', '<?php echo $user_username; ?>')">
										<img src="/aims/include/action/reset_password.png">
									</a>
									<a title="Delete" class="action-button mx-1" onclick="confirmDeleteUser('<?php echo $user_id; ?>', '<?php echo $user_username; ?>')">
										<img src="/aims/include/action/delete.png">
									</a>
								<?php } ?>
								</td>
							</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Tab 3: Module Access -->
	<div class="tab-content" id="tab-content-module-access">
		<div class="row ml-3">
			<div class="user-group-dropdown mb-3">
				<label for="user_group">User Group: </label>
				<select id="user_group" name="user_group" class="form-control" onchange="onSelectUserGroup(this.value);">
					<?php
						$sql = "SELECT * FROM aims_user_group WHERE id != '1' AND user_group_name != 'EXECUTIVE' AND status = 'ACTIVE'";
						$query = mysqli_query($con, $sql);

						while ($row = mysqli_fetch_assoc($query)) {
							$user_group_id = $row['id']; 	
							$user_group_name = $row['user_group_name'];
					?>
							<option value="<?php echo $user_group_id; ?>"><?php echo $user_group_name; ?></option>
					<?php
						}
					?>
				</select>
			</div>
			<div class="float-right ml-3">
				<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="" onclick="">Save</button> -->
			</div>
		</div>
		<div class="table-container">
			<table id="tbl-module-access">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>Module</th>
						<th>Submodule</th>
						<th>View</th>
						<th>Add</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>

	</div>
</div>

<!-- Modal -->
<?php include "iam_modal.php" ?>

<script>
$(document).ready(function() {
	<?php if ($tab == 'user-staff') { ?>
	$('#tab-content-user-group').hide();
	$('#tab-content-user-staff').show();
	$('#tab-content-module-access').hide();
	$('#tbl-module-access').hide();
	<?php } else { ?>
	$('#tab-content-user-group').show();
	$('#tab-content-user-staff').hide();
	$('#tab-content-module-access').hide();
	$('#tbl-module-access').hide();
	<?php } ?>

	onSelectUserGroup('<?php echo $_SESSION['aims_user_group_id']; ?>');

	$(".saveaddusergroup").click(function () {
		$.ajax({
			url: 'module/setting/iam/addusergroup_action.php',
			type: 'POST',
			data: {
				name: $('#add_userGroupName').val(),
				description: $('#add_userGroupDescription').val()
			},
			dataType: 'text',
			success: function(response) {
				if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User Group added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = 'main.php?page=iam'
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location = 'main.php?page=iam'
                    });
                }
			},
			error: function(xhr, status, error) {
				console.error("Error: ", error);
			}
		});
	});

	$(".saveeditusergroup").click(function () {
		$.ajax({
			url: 'module/setting/iam/editusergroup_action.php',
			type: 'POST',
			data: {
				id: $('#edit_userGroupId').val(),
				name: $('#edit_userGroupName').val(),
				description: $('#edit_userGroupDescription').val()
			},
			dataType: 'text',
			success: function(response) {
				if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User Group edited successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = 'main.php?page=iam'
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = 'main.php?page=iam'
                    });
                }
			},
			error: function(xhr, status, error) {
				console.error("Error: ", error);
			}
		});
	});
});

/* MODULE ACCESS */
function toggleCheckbox(e) {
	// console.log(e.checked);
	let name = $(e).prop('name');
	name = name.replace('[]', '');
	name = name.replace('submodule_', '');
	// console.log(name);

	let isChecked = e.checked ? 1 : 0;
	// console.log(isChecked);

	let tr = $(e).parent().parent();
	let tds = $(tr).children();
	let submoduleCell = tds[0];
	let submodule = $(submoduleCell).find("input[name='submodule[]']").val();
	let user_group_id = $('#user_group').val();

	$.ajax({
		url: 'module/setting/iam/update_module_access_ajax.php',
		type: 'POST',
		data: {
			user_group_id: user_group_id,
			name: name,
			submodule: submodule,
			is_checked: isChecked
		},
		dataType: 'text',
		success: function(response) {
			console.log(response);
			// Swal.fire({
			// icon: 'success',
			// title: 'Success',
			// text: 'The Module Access has been updated.',
			// showConfirmButton: false,
			// timer: 2000
			// })
			onSelectUserGroup(user_group_id);
		},
		error: function(xhr, status, error) {
			console.error("Error sending POST request:", error);
		}
	});
}

function onSelectUserGroup(user_group_id) {
	// console.log(user_group_id);

	// load tbl-module-access
	$.ajax({
		url: 'module/setting/iam/get_module_access_ajax.php',
		type: 'POST',
		data: {
			user_group_id: user_group_id
		},
		dataType: 'html',
		success: function(response) {
			// console.log(response);
			let table = $('#tbl-module-access');
			let tbody = table.find('tbody');
			tbody.html('');
			tbody.html(response);
			table.show();
		},
		error: function(xhr, status, error) {
			console.error("Error sending POST request:", error);
		}
	});
}

function openTab(name) {
	$('.tab-content').hide();
	$('.tab').removeClass('active');
	
	$('#tab-content-' + name).show();
	$('#tab-' + name).addClass('active');
}

/* USER GROUP */
// Add User Group
function addUserGroup() 
{
	$(".modalcontaineraddusergroup").fadeIn();
	$(".modaladdusergroup").fadeIn();

	$(".closeaddusergroup").click(function() {
		$(".modalcontaineraddusergroup").fadeOut();
		$(".modaladdusergroup").fadeOut();
	});

	$(".buttonsaddusergroup").click(function() {
		$(".modalcontaineraddusergroup").fadeOut();
		$(".modaladdusergroup").fadeOut();
	});
}

// Edit User Group
function editUserGroup(userGroupId, userGroupName, description) {
	$('#edit_userGroupId').val(userGroupId);
	$('#edit_userGroupName').val(userGroupName);
	$('#edit_userGroupDescription').val(description);

	$(".modalcontainereditusergroup").fadeIn();
	$(".modaleditusergroup").fadeIn();

	$(".closeeditusergroup").click(function() {
		$(".modalcontainereditusergroup").fadeOut();
		$(".modaleditusergroup").fadeOut();
	});

	$(".buttonseditusergroup").click(function() {
		$(".modalcontainereditusergroup").fadeOut();
		$(".modaleditusergroup").fadeOut();
	});
}

// View User Group
function viewUserGroup(userGroupId, userGroupName, description) {
	$('#view_userGroupId').val(userGroupId);
	$('#view_userGroupName').val(userGroupName);
	$('#view_userGroupDescription').val(description);

	$(".modalcontainerviewusergroup").fadeIn();
	$(".modalviewusergroup").fadeIn();

	$(".closeviewusergroup").click(function() {
		$(".modalcontainerviewusergroup").fadeOut();
		$(".modalviewusergroup").fadeOut();
	});

	$(".buttonsviewusergroup").click(function() {
		$(".modalcontainerviewusergroup").fadeOut();
		$(".modalviewusergroup").fadeOut();
	});
}

// Delete User Group
function confirmDeleteUserGroup(id, number, name) {
	Swal.fire({
		title: "Are you sure?",
		text: "You are about to delete User Group " + name + ".\nThere are " + number + " user(s) in the group.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel"
	}).then((result) => {
	if (result.isConfirmed) {
		deleteUserGroup(id, number);
	}
	});
}

function deleteUserGroup(id, number) {
	$.ajax({
	url: "module/setting/iam/deleteusergroup_action.php",
	type: "POST", 
	data: { id: id, number: number },
	success: function(response) {
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: 'The User Group has been deleted.',
			showConfirmButton: false,
			timer: 2000
		}).then(function() {
			window.location.href = 'main.php?page=iam';
		});
	},
	error: function(xhr, status, error) {
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: 'An error occurred while deleting the User Group. ' + error,
			showConfirmButton: true,
			timer: 2000
		}).then(function() {
			window.location.href = 'main.php?page=iam';
		});
	}
	});
}

/* USER */
// Reset Password User
function confirmResetPasswordUser(id, email, name) {
	Swal.fire({
		title: "Are you sure?",
		text: "You are about to reset to default password on User " + name + ".",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, reset it!",
		cancelButtonText: "Cancel"
	}).then((result) => {
	if (result.isConfirmed) {
		resetPasswordUser(id);
		}
	});
}

function resetPasswordUser(id) {
	$.ajax({
	url: "module/setting/iam/resetpassworduser_action.php",
	type: "POST", 
	data: { id: id },
	success: function(response) {
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: 'The User\'s password has been reseted.',
			showConfirmButton: false,
			timer: 2000
		}).then(function() {
			window.location.href = 'main.php?page=iam&tab=user-staff';
		});
	},
	error: function(xhr, status, error) {
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: 'An error occurred while reseting User\'s password. ' + error,
			showConfirmButton: true,
			timer: 2000
		}).then(function() {
			window.location.href = 'main.php?page=iam&tab=user-staff';
		});
	}
	});
}

// Delete User
function confirmDeleteUser(id, name) {
	Swal.fire({
		title: "Are you sure?",
		text: "You are about to delete User " + name + ".",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel"
	}).then((result) => {
	if (result.isConfirmed) {
		deleteUse(id);
		}
	});
}

function deleteUser(id) {
	$.ajax({
	url: "module/setting/iam/deleteuser_action.php",
	type: "POST", 
	data: { id: id },
	success: function(response) {
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: 'The User has been deleted.',
			showConfirmButton: false,
			timer: 2000
		}).then(function() {
			window.location.href = 'main.php?page=iam&tab=user-staff';
		});
	},
	error: function(xhr, status, error) {
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: 'An error occurred while deleting the User. ' + error,
			showConfirmButton: true,
			timer: 2000
		}).then(function() {
			window.location.href = 'main.php?page=iam&tab=user-staff';
		});
	}
	});
}
</script>