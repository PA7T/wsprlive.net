<?php
// CUDOs PHP Manual - https://www.macs.hw.ac.uk/~hwloidl/docs/PHP/
$uploadOk = 1;
$date = date_create();

if (preg_match('/[^a-zA-Z0-9\/]/i', $_POST[call])) {
 	echo 'The callsign contains illegal characters.';
	$uploadOk = 0;
}

if (preg_match('/[^a-zA-Z0-9]/i', $_POST[grid])) {
 	echo 'The grid contains illegal characters.';
	$uploadOk = 0;
}

// Check file size
if ($_FILES["allmept"]["size"] > 50000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

// if everything is ok, try to upload file
} else {
	$call = str_replace('/', '-', $_POST[call]);
	$call = preg_replace('/[^a-zA-Z0-9-]/', "", $call);
	$grid = preg_replace('/[^a-zA-Z0-9]/', "", $_POST[grid]);

	$uploaddir = '/PATHTO/uploads/';
	$uploadfile = $uploaddir . date_timestamp_get($date) . '_' . $call . '_' . $grid;

	//echo '<pre>';
	if (move_uploaded_file($_FILES['allmept']['tmp_name'], $uploadfile)) {
		echo "OK\n";
	} else {
		echo "Possible file upload attack!\n";
	}

	/*echo 'Here is some more debugging info:';
	print_r($_FILES);
	print_r($_POST[call]);
	print_r($_POST[grid]);
	print "</pre>";*/
}
?>
