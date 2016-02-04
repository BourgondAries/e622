<?php
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Tag.php';

	$media = new Media;
	$tags = $media->getAllTagsGloballyByCount();
	$taghtml = Tag::render($tags);
	echo Standard::render('Here you can see the most common tags in the database. Any non-whitespace broken sequence of characters constitutes a single tag. The number in the parentheses represent the amount of media that is tagged with that tag. If tags have the same number of media, then they will be sorted alphabetically.', $taghtml, User::generateLoginState());
?>
