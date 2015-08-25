<?php
	require_once 'utils/StringManip.php';
	class UploadPage
	{
		static function render($previous_description = '', $previous_tags = '')
		{
			return intermix(self::$upload_form, [$previous_description, $previous_tags]);
		}

		static function renderSuccess($id)
		{
			return intermix(self::$success_box, [$id]);
		}

		static private $success_box =
		[
			'<div class="notification">
				Previous upload successful with ID ',

			'</div><div class="vertical space"></div>'
		];

		static function renderFail($reason)
		{
			switch ($reason)
			{
				case 'wrong_no_privilege': $reason = 'This account does not have the privilege to upload media.'; break;
				case 'wrong_no_tags': $reason = 'No tags were provided. Every medium must have at least one tag.'; break;
				case 'wrong_submime': $reason = 'The type is an image or video, but not the supported format. webm, gif, png, hpg, and jpeg are supported.'; break;
				case 'wrong_mime': $reason = 'Wrong major type: only image and video are supported.'; break;
				default: break;
			}
			return intermix(self::$warning_box, [$reason]);
		}

		static private $warning_box =
		[
			'<div class="warning">',

			'</div><div class="vertical space"></div>'
		];

		static function renderInformation($notice = '')
		{
			return $notice . self::$information;
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
							<div class="smalltext">
								<div class="leftpad">
									A descriptive text to go with your media. Please put possible sources of the media here, as well as the story or reason for the media if it is available. Note that the artist can be put in the tag using \'artist:name\'. The description is limited to 1024 characters. We recommend following these suggestions, but you\'re free to write whatever you want.
								</div>
							</div>
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<textarea name="description" placeholder="This is my grandparents\' belgian malinois. This is a picture of her taken when she was ten years old. Her face is awkward when she squints.">',

							'</textarea>
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Tags
							<div class="smalltext">
								<div class="leftpad">
									Tags that will match a search. Tags are space-separated. Multiple words must be mimicked using underscores. There are three reserved tags: \'sfw\', \'qsfw\', and \'nsfw\'. These stand for <em>safe for work</em>, <em>questionably safe for work</em>, and <em>not safe for work</em>, respectively. Tagging with these will provide a small icon beside the thumbnail. If you do not tag any of the reserved tags, nsfw will be inserted for you. \'artist:name\' should be used to give an artist.
								</div>
							</div>
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<textarea name="taglist" placeholder="happy belgian_malinois dog squinting -- sfw bone black_muzzle blonde_hair teeth canine pointy_ears brown_eyes">',

							'</textarea>
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Link
							<div class="smalltext">
								<div class="leftpad">
									The image ID of the previous medium in the set. Allows you to bundle images into an easily scrollable collection. Only needed if you upload logically coherent sets of media.
								</div>
							</div>
						</div>
						<div class="cell">
						</div>
						<div class="cell">
							<textarea name="link" placeholder="link id"></textarea>
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							Autolink
							<div class="smalltext">
								<div class="leftpad">
									If you want to fill in the link automatically with the previously uploaded medium ID.
								</div>
							</div>
						</div>
						<div class="cell">
						</div>
						<div class="cell">
							<input name="autolink" type="checkbox">
						</div>
					</div>
					<div class="row"><div class="vertical space"></div></div>
					<div class="row">
						<div class="cell">
							<div class="little horizontal space">
							</div>
						</div>
						<div class="cell"><div class="horizontal space"></div></div>
						<div class="cell">
							<input type="submit" value="upload">
						</div>
					</div>
				</div>
				<div class="vertical space"></div>
				<div class="smalltext">
					The tag system is central to the searching methods and general philosophy. The first few words of the tags ought to be semi-descriptive. They must read as an english sentence without conjunctions (and, or, but, because). An example is <em> happy belgian_malinois dog squinting -- sfw bone black_muzzle blonde_hair teeth canine pointy_ears brown_eyes </em>. Observe how the first four words are descriptive, and the rest are less so. Tags after -- are sorted alphabetically. If you do not insert a -- tag, nothing will be sorted.
				</div>
			</form>'
		];
	}
?>
