<?php
include_once '../../include/db_connection.php';

$id = $_POST['id'];

$news_q = mysqli_query($con,"SELECT * FROM aims_news WHERE id = '".$id."' AND display_status = 'ACTIVE'");
$news = mysqli_fetch_assoc($news_q);	
?>

<style>
#img:hover {
	opacity: 0.7;
	cursor: pointer;
}
#imgFile:hover
{
	cursor: pointer;
}
.info:hover {
	cursor: pointer;
}

/*START IMG MODAL*/
/* The Modal (background) */
.modal2 {
  display: block; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content2 {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content2, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close2 {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close2:hover,
.close2:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
/*END IMG MODAL*/
</style>

<div class="col-12">
	<div class="row">
		<div class="col-6">
			<div class="row spacerow">
				<div class="col-4 sub" style="margin-bottom: 1rem;"><b>TITLE</b></div>
				<div class="col-7"><?php echo $news['name']; ?></div>
			</div>

			<div class="row spacerow">
				<div class="col-4 sub" style="margin-bottom: 1rem;"><b>DATE</b></div>
				<div class="col-7"><?php echo $news['date_created']; ?></div>
			</div>

            <div class="row spacerow">
				<div class="col-4 sub" style="margin-bottom: 1rem;"><b>PUBLISHER</b></div>
				<div class="col-7"><?php echo $news['publisher']; ?></div>
			</div>

            <div class="row spacerow">
				<div class="col-4 sub" style="margin-bottom: 1rem;"><b>DESCRIPTION</b></div>
			</div>
		</div>
		<div class="col-12">
			<div class="row spacerow">
				<div class="col-10"><?php echo $news['description']; ?></div>
			</div>
		</div>
    </div>
</div>

<script type="text/javascript">
function close_img_modal()
{
	$('#imgModal').modal('hide');
	$('#imgModal').detach();
}
</script>