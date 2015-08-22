<?php
	class Standard
	{
		static function render($main_content, $under_search_bar, $loginstate = ['LOGIN', '/login'])
		{
			$inserter = [$under_search_bar, $main_content];
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
				</head>
				<body>
					<div class="generic">
						<div class="row">
							<div class="prefoot">
								<div class="table">
									<div class="row">
										<div class="navigation_bar">
											<div class="table">
												<a href="#"> e622 </a>
												<a href="',

												'">',

												'</a>
												<a href="#"> UPLOAD </a>
												<a href="#"> TAGS </a>
												<a href="#"> SUPPORT </a>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="content">
											<div class="table">
												<div class="cell-right-marged">
													<div class="searchtable">
														<div class="row">
															Search <a class="searchhelp" href="/help">(search help)</a>
														</div>
														<div class="row">
															<form action="/search/search.php" method="get">
																<input class="searchbar" name="tags" placeholder="your tags" type="text">
																<br>
																<input class="searchbar_button" name="submit" type="submit" value="search">
															</form>
														</div>
														<div class="row">',

														'</div>
													</div>
												</div>
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
					</div>
				</body>
			</html>'
		];
	}
?>
