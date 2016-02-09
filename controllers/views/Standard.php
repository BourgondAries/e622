<?php
	class Standard
	{
		static function renderSidebar()
		{
			return self::$templateside[0];
		}

		static private $templateside =
		[
			'<div class="update smalltext">
				<ul>
					<strong> Scroll through search pages using the arrow keys. </strong>
					<li> You can now expand pictures by clicking on them. </li>
				</ul>
			</div>'
		];

		static function render($main_content, $under_search_bar, $loginstate = ['LOGIN', '/login'], $filled_tags = '')
		{
			$inserter = [$under_search_bar, $main_content, $filled_tags];
			foreach ($loginstate as &$value)
				$inserter[] = $value;
			$generated = '';
			foreach (self::$template as &$part)
				$generated .= $part . array_pop($inserter);
			return $generated;
		}

		static private $template =
		[
			'<!DOCTYPE html>
			<html>
				<head>
					<style> @import url("/controllers/views/style/reset.css"); </style>
					<style> @import url("/controllers/views/style/index.css"); </style>
					<link rel="icon" type="image/png" href="/storage/icons/favicon16x16.png" sizes="16x16">
					<link rel="icon" type="image/png" href="/storage/favicon32x32.png" sizes="32x32">
					<link rel="icon" type="image/png" href="/storage/favicon48x48.png" sizes="48x48">
				</head>
				<body class="e622" onkeydown="navigate(event);">
					<div class="row">
						<div class="prefoot">
							<div class="table">
								<div class="row">
									<div class="navigation_bar">
										<a href="/"><div class="vertical space"></div>
e622<div class="vertical space"></div></a>
										<a href="',

										'">',

										'</a>
										<a href="/upload"> UPLOAD </a>
										<a href="/tags"> TAGS </a>
										<a href="/support"> SUPPORT </a>
									</div>
								</div>
								<div class="row">
									<div class="content">
										<div class="table">
											<div class="small table-column"></div>
											<div class="tiny table-column"></div>
											<div class="max table-column"></div>
											<div class="cell">
												<div class="table">
													<div class="row">
														Search <a class="tinytext" href="/help">(search help)</a>
													</div>
													<div class="row"><div class="vertical space"></div></div>
													<div class="row">
														<form action="/search/" method="get">
															<input name="tags" placeholder="your tags" type="text" value="', '">
															<div class="row"><div class="vertical space"></div></div>
															<input type="submit" value="search">
														</form>
													</div>
													<div class="row"><div class="vertical space"></div></div>
													<div class="row">',

													'</div>
												</div>
											</div>
											<div class="cell"></div>
											<div class="cell">',

											'</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="footer">
							<div class="center">
								<div class="autotable">
									<div class="row">
										<div class="cell">',

											'Design
										</div>
										<div class="cell">
											|
										</div>
										<div class="cell">
											Kevin R. S.
										</div>
									</div>
									<div class="row">
										<div class="cell">
											Website
										</div>
										<div class="cell">
											|
										</div>
										<div class="cell">
											e622
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>'
		];
	}
?>
