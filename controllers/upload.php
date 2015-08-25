<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/UploadPage.php';

	$notice = '';
	if (Http::has('newid'))
		$notice = UploadPage::renderSuccess(Http::get('newid'));
	else if (Http::has('reason'))
		$notice = UploadPage::renderFail(Http::get('reason'));
	$upload_form = UploadPage::render(Http::get('description'), Http::get('taglist'), Http::get('newid'), Http::get('autolink'));
	echo Standard::render(UploadPage::renderInformation($notice), $upload_form, User::generateLoginState());
?>
