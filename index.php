<?php 
include('header.php');
?>
<title>phpzag.com : Demo Reduce or Compress Image Size While Uploading in PHP</title>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" src="scripts/upload.js"></script>
<link type="text/css" rel="stylesheet" href="style.css" />
<?php include('container.php');?>
<link type="text/css" rel="stylesheet" href="style.css" />
<div class="container">
	<h2>Resize and Compress image size While Uploading in PHP</h2>
	<br>
	<br>	
	<form method="post" name="upload_form" id="upload_form" enctype="multipart/form-data" action="upload.php">   
		<label>Choose Images to Upload</label>
		<br>
		<br>
		<input type="file" name="upload_images" id="image_file">
		<div class="file_uploading hidden">
			<label>&nbsp;</label>
			<img src="uploading.gif" alt="Uploading......"/>
		</div>
	</form>
	<div id="uploaded_images_preview"></div>

	<br>	
</div>
<?php include('footer.php');?>
