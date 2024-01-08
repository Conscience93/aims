<?php
include_once 'include/db_connection.php';

include './module/news/viewnews_modal.php';
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

	/* .modal {
		background-color: beige;
	} */

	.action-button {
		cursor: pointer;
	}
</style>

<!-- Navigation -->
<div class="main">
	<div class="tab-container-title mb-5"><h2>News & Updates</h2></div>
	<div class="tabs">
		<div class="tab active" id="tab-news" onclick="openTab('news')">News</div>
		<div class="tab" id="tab-update" onclick="openTab('update')">Technical Update</div>
		<div class="tab" id="tab-advertisement" onclick="openTab('advertisement')">Advertisement</div>
		<div class="tab" id="tab-others" onclick="openTab('other')">Others</div>
	</div>

	<!-- News Group -->
	<div class="tab-content" id="tab-content-news">
		<div class="control-button-container mb-3">
			<!-- <button type="button" class="btn btn-danger" onclick="history.back();">Back</button> -->
			<a href="./addnews" class="btn btn-info">Add</a>
		</div>
		<div class="table-container">
			<table id="tbl-news">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>News</th>
                        <th>Publisher</th>
						<th>Date</th>
						<th>Date Edited</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count_news = 0;
						$sql_news = "SELECT * FROM aims_news WHERE category = 'NEWS' AND display_status = 'ACTIVE'";
						$query_news = mysqli_query($con, $sql_news);
	
						while ($row = mysqli_fetch_assoc($query_news)) {
						if ($row) {
							$news_id = $row['id'];
							$news_name = $row['name'];
							$news_publisher = $row['publisher'];
                            $news_date = $row['date_created'];
							$news_date_edited = $row['date_edited'] ? $row['date_edited'] : "-" ;
                            $news_description = $row['description'];
					?>
							<tr>
								<td><?php echo ++$count_news; ?></td>
								<td><?php echo $news_name; ?></td>
								<td><?php echo $news_publisher; ?></td>
                                <td><?php echo $news_date; ?></td>
								<td><?php echo $news_date_edited; ?></td>
								<td>
                                    <a title="More Info" data-toggle="modal" data-target="#newsModal" class="action-button mx-1 mr-1" onclick="viewNewsModal('<?php echo $news_id; ?>')">
										<img src="/aims/include/action/review.png">
									</a>
									<a title="Edit" class="action-button mx-1 mr-1" href="./editnews?id=<?php echo $news_id; ?>">
										<img src="/aims/include/action/edit.png">
									</a>
									<a title="Delete" class="action-button mx-1" onclick="deleteNews('<?php echo $news_id; ?>')">
										<img src="/aims/include/action/delete.png">
									</a>
								</td>
							</tr>
					<?php
						} else {
					?>
						<td>No News found!</td>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Technical Update Group -->
	<div class="tab-content fade" id="tab-content-update">
		<div class="control-button-container mb-3">
			<!-- <button type="button" class="btn btn-danger" onclick="history.back();">Back</button> -->
			<a href="./addnews" class="btn btn-info">Add</a>
		</div>
		<div class="table-container">
			<table id="tbl-update">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>Update</th>
                        <th>Publisher</th>
						<th>Date</th>
						<th>Date Edited</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count_update = 0;
						$sql_update = "SELECT * FROM aims_news WHERE category = 'UPDATE' AND display_status = 'ACTIVE'";
						$query_update = mysqli_query($con, $sql_update);
	
						while ($row = mysqli_fetch_assoc($query_update)) {
							$update_id = $row['id'];
							$update_name = $row['name'];
							$update_publisher = $row['publisher'];
                            $update_date = $row['date_created'];
							$update_date_edited = $row['date_edited'] ? $row['date_edited'] : "-" ;
                            $update_description = $row['description'];
					?>
							<tr>
								<td><?php echo ++$count_update; ?></td>
								<td><?php echo $update_name; ?></td>
								<td><?php echo $update_publisher; ?></td>
                                <td><?php echo $update_date; ?></td>
								<td><?php echo $update_date_edited; ?></td>
								<td>
									<a title="More Info" data-toggle="modal" data-target="#newsModal" class="action-button mx-1 mr-1" onclick="viewNewsModal('<?php echo $news_id; ?>')">
										<img src="/aims/include/action/review.png">
									</a>
									<a title="Edit" class="action-button mx-1 mr-1" href="./editnews?id=<?php echo $news_id; ?>">
										<img src="/aims/include/action/edit.png">
									</a>
									<a title="Delete" class="action-button mx-1" onclick="deleteNews('<?php echo $news_id; ?>')">
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

	<!-- Advertisement Group -->
	<div class="tab-content fade" id="tab-content-advertisement">
		<div class="control-button-container mb-3">
			<!-- <button type="button" class="btn btn-danger" onclick="history.back();">Back</button> -->
			<a href="./addnews" class="btn btn-info">Add</a>
		</div>
		<div class="table-container">
			<table id="tbl-advertisement">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>Advertisement</th>
                        <th>Publisher</th>
						<th>Date</th>
						<th>Date Edited</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count_advertisement = 0;
						$sql_advertisement = "SELECT * FROM aims_news WHERE category = 'ADVERTISEMENT' AND display_status = 'ACTIVE'";
						$query_advertisement = mysqli_query($con, $sql_advertisement);
	
						while ($row = mysqli_fetch_assoc($query_advertisement)) {
							$advertisement_id = $row['id'];
							$advertisement_name = $row['name'];
							$advertisement_publisher = $row['publisher'];
                            $advertisement_date = $row['date_created'];
							$advertisement_date_edited = $row['date_edited'] ? $row['date_edited'] : "-" ;
                            $advertisement_description = $row['description'];
					?>
							<tr>
								<td><?php echo ++$count_advertisement; ?></td>
								<td><?php echo $advertisement_name; ?></td>
								<td><?php echo $advertisement_publisher; ?></td>
                                <td><?php echo $advertisement_date; ?></td>
								<td><?php echo $advertisement_date_edited; ?></td>
								<td>
									<a title="More Info" data-toggle="modal" data-target="#newsModal" class="action-button mx-1 mr-1" onclick="viewNewsModal('<?php echo $news_id; ?>')">
										<img src="/aims/include/action/review.png">
									</a>
									<a title="Edit" class="action-button mx-1 mr-1" href="./editnews?id=<?php echo $news_id; ?>">
										<img src="/aims/include/action/edit.png">
									</a>
									<a title="Delete" class="action-button mx-1" onclick="deleteNews('<?php echo $news_id; ?>')">
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

	<!-- Other Group -->
	<div class="tab-content fade" id="tab-content-other">
		<div class="control-button-container mb-3">
			<!-- <button type="button" class="btn btn-danger" onclick="history.back();">Back</button> -->
			<a href="./addnews" class="btn btn-info">Add</a>
		</div>
		<div class="table-container">
			<table id="tbl-other">
				<thead class="sticky-header">
					<tr>
						<th>No.</th>
						<th>other</th>
                        <th>Publisher</th>
						<th>Date</th>
						<th>Date Edited</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count_other = 0;
						$sql_other = "SELECT * FROM aims_news WHERE category = 'OTHER' AND display_status = 'ACTIVE'";
						$query_other = mysqli_query($con, $sql_other);
	
						while ($row = mysqli_fetch_assoc($query_other)) {
							$other_id = $row['id'];
							$other_name = $row['name'];
							$other_publisher = $row['publisher'];
                            $other_date = $row['date_created'];
							$other_date_edited = $row['date_edited'] ? $row['date_edited'] : "-" ;
                            $other_description = $row['description'];
					?>
							<tr>
								<td><?php echo ++$count_other; ?></td>
								<td><?php echo $other_name; ?></td>
								<td><?php echo $other_publisher; ?></td>
                                <td><?php echo $other_date; ?></td>
								<td><?php echo $other_date_edited; ?></td>
								<td>
									<a title="More Info" data-toggle="modal" data-target="#newsModal" class="action-button mx-1 mr-1" onclick="viewNewsModal('<?php echo $news_id; ?>')">
										<img src="/aims/include/action/review.png">
									</a>
									<a title="Edit" class="action-button mx-1 mr-1" href="./editnews?id=<?php echo $news_id; ?>">
										<img src="/aims/include/action/edit.png">
									</a>
									<a title="Delete" class="action-button mx-1" onclick="deleteNews('<?php echo $news_id; ?>')">
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


<script>
$(document).ready(function() {
	$('#tab-news').addClass('active');
	$('#tab-content-news').show();
	$('#tab-content-updates').hide();
	$('#tab-content-others').hide();
	$('#tbl-module-access').hide();
});

function openTab(name) {
	$('.tab-content').hide();
	$('.tab').removeClass('active');
	
	$('#tab-content-' + name).show();
	$('#tab-content-' + name).removeClass('fade');
	$('#tab-' + name).addClass('active');
}

// News
function viewNewsModal(id) 
{
	$(".modalcontainernewsview").fadeIn();
	$(".modalnewsview").fadeIn();

	viewNewsContent(id);

	$(".closenewsview").click(function() {
		$(".modalcontainernewsview").fadeOut();
		$(".modalnewsview").fadeOut();
	});

	$(".buttonsnewsview").click(function() {
		$(".modalcontainernewsview").fadeOut();
		$(".modalnewsview").fadeOut();
	});
}

function viewNewsContent(id)
{
	var dataString = "id="+id;

	$.ajax({
		url: './module/news/viewnews.php',
		type: 'POST',
		data: dataString,
		success: function(result) 
		{
			if(result != "")
			{
				$(".modalcontnewsview").html(result);
			}
		}
	});	
}

function deleteNews(id) {
	$.ajax({
	url: "./module/news/deletenews_action.php", // Update the URL to your PHP script
	type: "POST", // Use POST method
	data: { id: id }, // Send the ID as data
	success: function(response) {
		// Handle the server response here if needed
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: 'The news has been deleted.',
			showConfirmButton: false,
			timer: 2000
		}).then(function() {
			window.location.href = './news';
		});
		// You can also update the UI or perform any other action
	},
	error: function(xhr, status, error) {
		// Handle errors here if needed
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: 'An error occurred while deleting the news.' + error,
			showConfirmButton: true,
			timer: 2000
		}).then(function() {
			window.location.href = './news';
		});
	}
	});
}

// Update
function viewUpdateModal(id) 
{
	$(".modalcontainernewsview").fadeIn("slow");
	$(".modalnewsview").fadeIn("slow");

	viewNewsContent(id);

	$(".closenewsview").click(function() {
		$(".modalcontainernewsview").fadeOut("slow");
		$(".modalnewsview").fadeOut("slow");
	});

	$(".buttonsnewsview").click(function() {
		$(".modalcontainernewsview").fadeOut("slow");
		$(".modalnewsview").fadeOut("slow");
	});
}

function viewNewsContent(id)
{
	var dataString = "id="+id;

	$.ajax({
		url: './module/news/viewnews.php',
		type: 'POST',
		data: dataString,
		success: function(result) 
		{
			if(result != "")
			{
				$(".modalcontnewsview").html(result);
			}
		}
	});	
}

function deleteNews(id) {
	$.ajax({
	url: "./module/news/deletenews_action.php", // Update the URL to your PHP script
	type: "POST", // Use POST method
	data: { id: id }, // Send the ID as data
	success: function(response) {
		// Handle the server response here if needed
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: 'The news has been deleted.',
			showConfirmButton: false,
			timer: 2000
		}).then(function() {
			window.location.href = './news';
		});
		// You can also update the UI or perform any other action
	},
	error: function(xhr, status, error) {
		// Handle errors here if needed
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: 'An error occurred while deleting the news.' + error,
			showConfirmButton: true,
			timer: 2000
		}).then(function() {
			window.location.href = './news';
		});
	}
	});
}

// Advertisement

// Other

</script>