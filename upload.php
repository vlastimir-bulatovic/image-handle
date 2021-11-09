<?php 

	$file_type_error = '';
	if($_FILES['upload_images']['name']) {	  
		$upload_dir = "uploads/";	
		if (($_FILES["upload_images"]["type"] == "image/gif") ||
		   ($_FILES["upload_images"]["type"] == "image/jpeg") ||
		   ($_FILES["upload_images"]["type"] == "image/png") ||
		   ($_FILES["upload_images"]["type"] == "image/pjpeg")) {
			
			$file_name = $_FILES["upload_images"]["name"];

			$tmp = (explode(".", $file_name));
			$extension = end($tmp);
			
			$upload_file = $upload_dir.$file_name;		
			if(move_uploaded_file($_FILES['upload_images']['tmp_name'],$upload_file)){			  
				$source_image = $upload_file;
				$image_destination = $upload_dir."medium-".$file_name;
				$compress_images = compressImage($source_image, $image_destination);
				 
				$directory= $compress_images;
				resizeImage($compress_images,$directory);
			}		 
		} else {
			$file_type_error = "Upload only jpg or gif or png file type";
		}	
	}
	

	


	// created compressed  file from source file
	function compressImage($source_image, $compress_image) {

		$image_info = getimagesize($source_image);	

		if ($image_info['mime'] == 'image/jpeg') { 
			$source_image = imagecreatefromjpeg($source_image);
			imagejpeg($source_image, $compress_image, 85);
		} elseif ($image_info['mime'] == 'image/gif') {
			$source_image = imagecreatefromgif($source_image);
			imagegif($source_image, $compress_image, 85);
		} elseif ($image_info['mime'] == 'image/png') {
			$source_image = imagecreatefrompng($source_image);
			imagepng($source_image, $compress_image, 8);
		}	    
		return $compress_image;
	}

	// resize to 300x300 from source file
	function resizeImage($fileName,$directory){

		list($width,$height,$type) = getimagesize($fileName);
		$new_height = 300;
		$new_width=300;

		$old_image = imagecreatetruecolor($new_width,$new_height);
		switch($type){
			case IMAGETYPE_JPEG:
				$new_image = imagecreatefromjpeg($fileName);
				break;
			case IMAGETYPE_GIF:
				$new_image = imagecreatefromgif($fileName);
				break;
			case IMAGETYPE_PNG:
				imagealphablending($old_image, false);
				imagesavealpha($old_image, true);
				$new_image = imagecreatefrompng($fileName);
				break;
		}
		switch($type){
			case IMAGETYPE_JPEG:
				imagecopyresampled($old_image,$new_image,0,0,0,0,$new_width,$new_height,$width,$height);
				imagejpeg($old_image,$directory);
				break;
			case IMAGETYPE_GIF:
				$bgcolor = imagecolorallocatealpha($new_image,0,0,0,127);
				imagefill($old_image, 0, 0, $bgcolor);
				imagecolortransparent($old_image,$bgcolor);
				imagecopyresampled($old_image,$new_image,0,0,0,0,$new_width,$new_height,$width,$height);
				imagegif($old_image,$directory);
				break;
			case IMAGETYPE_PNG:
				imagecopyresampled($old_image,$new_image,0,0,0,0,$new_width,$new_height,$width,$height);
				imagepng($old_image,$directory);
				break;
		}
		imagedestroy($old_image);
		imagedestroy($new_image);
    }
?>