<?php
$targetDir = "uploads/";
$targetFile = $targetDir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);
//Kiem tra file upload co dung la file hinh khong
if (isset($_POST["submit"])) {
$check = getimagesize( $_FILES["fileToUpload"]["tmp_name"]);
	if ($check !== false) {
		echo "File is an image - ".$check["mime"].".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}
//kiem tra file da trung
if (file_exists($targetFile)) {
	echo "Sorry, file already exits";
	$uploadOk = 0;
}

//kiem tra kich thuoc file
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
	echo "Sorry , only JPG, JPEG , PNG & GIF files are allowed.";
	$uploadOk = 0;
}
//Kiem tra neu $uploadOk
if($uploadOk == 0){
	echo "Sorry, your file was not uploaded.";
	//neu moi thu ok, thi co gang upload file
}else{
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$targetFile)){
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). "has been uploaded.";
	}else{
		echo "Sorry, there was an error uploading your file.";
	}
}

?>