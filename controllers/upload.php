<?php
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/UploadPage.php';

	$upload_form = UploadPage::render();
	echo Standard::render(UploadPage::renderInformation(), $upload_form, User::generateLoginState());
?>
