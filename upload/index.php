<?php
	session_start();
	if (!isset($_SESSION['username'])) {
		header('Location: ' . '/login/index.php?reason=upload');
		die();
	}
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";

	// Here we need some forms
	$template = "<form action=\"/postupload/post.php\" method=\"post\">
		<div class=\"upload\">
			<div style=\"display: table-row;\">
				<div id=\"filedescriptor\">
					File to upload:
				</div>
				<div id=\"file\">
					<input id=\"filepick\" type=\"file\" name=\"file\">
				</div>
			</div>
			<div class=\"story\">
				<div class=\"damn\">
					Descripton:
					<div class=\"elaboration\">
						Write a short description or story regarding the media. Most of the descriptive text ought to be given as tags. This area is for extra information such as the reason, date, or location that the media was created. Why it was created and by whom and/or how.
					</div>
				</div>
				<div id=\"description\">
					<textarea name=\"description\" placeholder=\"Diamond Tiara is crying because I painted her that way and I've been working on ...\"></textarea>
				</div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">
					Tags:
					<div class=\"elaboration\">
						Make sure the first few tags read like a descriptive sentence. The rest of the tags ought to be all relevant search tags. See the placeholder for the example of correct tag usage. Special tags are 'sfw', 'nsfw', 'qsfw', 'author:name'. Separate by spaces.
					</div>
				</div>
				<div class=\"cell\">
					<textarea name=\"description\" placeholder=\"diamond_tiara_(mlp) crying screaming tears mlp fim angry blue_eyes open_mouth pink equine horse mane author:zorroW\"></textarea>
				</div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">
					Rating:
					<div class=\"elaboration\">
						Select whether the media is Safe For Work, Questionably Safe For Work, Not Safe For Work.
					</div>
				</div>
				<div class=\"cell\">
					<label class=\"ups\"> <input name=\"rating\" type=\"radio\" value=\"SFW\" checked>&#9888; SFW </label>
					<label class=\"favorites\"> <input name=\"rating\" type=\"radio\" value=\"QSFW\">&#9888; QSFW </label>
					<label class=\"downs\"> <input name=\"rating\" type=\"radio\" value=\"NSFW\">&#9888; NSFW </label>
					<div class=\"elaboration\">
						SFW material is normally not saucy or suggestive. It is sexually neutral as well as politically neutral. QSFW material may be saucy or suggestive. It can also be politically offensive or more commonly 'stuff you don't really want to have people looking over your shoulder see'. NSFW is completely unsafe. Sexually explicit media must be under NSFW. Non-sexual content can not fall under NSFW.
					</div>
				</div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">
					Link:
					<div class=\"elaboration\">
						To link to another medium.
					</div>
				</div>
				<div class=\"cell\">
					<input id=\"link\" type=\"text\" placeholder=\"24910\">
					<div class=\"elaboration\">
						Sometimes you want to link to another medium. This can occur when you have a comic strip separated into different images. You can upload the first image, then, on the second image you link to the first image's ID. This allows users to easily hop to the next pane by following the links. Links can be empty.
					</div>
				</div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">
					Upload:
				</div>
				<div class=\"cell\">
					<input id=\"uploadnow\" type=\"submit\" value=\"Upload\">
				</div>
			</div>
		</div>
	</form>";

	$responsibilities = '<div class="upload"> Notice: <div class="selaboration"> e622 reserves the rights to revoke or delete any upload due to: the copyright holder\'s request of deletion, or, the breaking of any laws pertaining the media being uploaded. <br> You are responsible for the media you upload and may be held accountable. <br> You are free to upload whatever is within the bounds of the law. <br><br> The media uploaded to e622 is publicly available. By uploading you give e622 consent to propagate and redistribute copies of the media. (We need a lawyer to write this stuff). <br><br> We (e622 staff) will never delete media based on our own personal beliefs, public opinion, or whatever non-judiciary reason. </div></div>';
	echo generateTemplate($template, $responsibilities);
?>
