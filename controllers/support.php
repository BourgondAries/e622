<?php
	require_once "models/User.php";
	require_once "views/Standard.php";
	require_once "views/Support.php";

	echo Standard::render(Support::getBar(), Support::getText(), User::generateLoginState());
?>
