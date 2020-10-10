<?php

$target_file = BASE_URL .'resources/images/'.basename($image_file);
$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
/* Check if image already exists in target folder, to ensure no image overwriting */
if(file_exists($target_file)){
    array_push($errors, 'There is already an image with the same name. Try change the name and continue.');
}
/* Check image size */
if($_FILES['post_main_image']['size']>5000000){
    array_push($errors, 'Sorry, image is too large');
    
/* Allow only .jpg, .png and .gif file formats */
}else if($imageFileType != 'jpg' && $imageFileType != 'png' && 		$imageFileType != 'gif'){
    array_push($errors,'Sorry, only JPG, PNG or GIF files are allowed');
}
if(!move_uploaded_file($_FILES['post-main-image']['tmp_name'], $target_file)){
    array_push($errors, 'Post image could not be uploaded, if problem persists try publishing without the image.');
}else{
    $image_path = BASE_URL ."resources/images/".basename($image_file);
}