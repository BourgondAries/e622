<?php
	require_once 'utils/StringManip.php';
	class UploadPage
	{
		static function render()
		{
			return intermix(self::$upload_form, ['']);
		}

		static function renderInformation()
		{
			return self::$information;
		}

		static private $information = '<div class="smalltext">
				Notice: e622 reserves the rights to revoke or delete any upload due to: the copyright holder\'s request of deletion, or, the breaking of any laws pertaining the media being uploaded. <br> You are responsible for the media you upload and may be held accountable. <br> You are free to upload whatever is within the bounds of the law. <br><br> The media uploaded to e622 is publicly available. By uploading you give e622 consent to propagate and redistribute copies of the media. (We need a lawyer to write this stuff). <br><br> We (e622 staff) will never delete media based on our own personal beliefs, public opinion, or whatever non-judiciary reason.
			</div>';

		static private $upload_form =
		[
			'<form action="/performupload" enctype="multipart/form-data" method="post">
				<div class="autotable">
					<div class="auto table-column"></div>
					<div class="tiny table-column"></div>
					<div class="max table-column"></div>
					<div class="row">
						<div class="cell">
							File to upload
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<input name="mediafile" type="file">
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Description
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<textarea name="description"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="cell">
							Tags
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<textarea name="description"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="cell">
							Upload
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<input type="submit" value="upload">
						</div>
					</div>
				',

				'</div>
			</form>'
		];
	}
?>
