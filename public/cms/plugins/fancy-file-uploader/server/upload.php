<?php
	require_once "fancy_file_uploader_helper.php";

	function ModifyUploadResult(&$result, $filename, $name, $ext, $fileinfo)
	{
		// Add more information to the result here as necessary (e.g. a URL to the file that a callback uses to link to or show the file).
	}

	$options = array(
		"allowed_exts" => array("jpg", "png"),
		"filename" => __DIR__ . "/images/" . $id . ".{ext}",
//		"result_callback" => "ModifyUploadResult"
	);

	FancyFileUploaderHelper::HandleUpload("files", $options);
?>