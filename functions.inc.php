<?php
if (!function_exists('pr')) {
	function pr($arr){
		echo '<pre>';
		print_r($arr);
	}
}


if (!function_exists('prx')) {
	function prx($arr){
		echo '<pre>';
		print_r($arr);
		die();
	}
}


if (!function_exists('get_safe_value')) {
	function get_safe_value($con,$str){
		if($str!=''){
			$str=trim($str);
			return mysqli_real_escape_string($con,$str);
		}
	}
}


if (!function_exists('isAdmin')) {
	function isAdmin(){
		if(!isset($_SESSION['ADMIN_LOGIN'])){
		?>
			<script>
			window.location.href='login.php';
			</script>
			<?php
		}
		if($_SESSION['ADMIN_ROLE']==1){
			?>
			<script>
			window.location.href='logout.php';
			</script>
			<?php
		}
	}
}


if (!function_exists('uploadFile')) {
	function uploadFile($file_input, $folder_name) {
		$target_dir = '../uploads/' . $folder_name . '/';
		$file_name = basename($_FILES[$file_input]['name']);
		$target_file = $target_dir . $file_name;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		
		// Check file size
		if ($_FILES[$file_input]['size'] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
			echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, DOCX files are allowed.";
			$uploadOk = 0;
		}
		
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			return "";
		} else {
			if (move_uploaded_file($_FILES[$file_input]['tmp_name'], $target_file)) {
				return $file_name;
			} else {
				echo "Sorry, there was an error uploading your file.";
				return "";
			}
		}
	}
}

?>