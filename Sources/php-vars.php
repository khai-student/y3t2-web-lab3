<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Labwork 4</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="./js/animation.js"></script>
</head>
<body>
	<div class="app">
		<img src="pictures/ball.png" id="logoBall" alt="" onclick="animation()" />
		<?php
			require_once "./php/header.html"
		?>
		<main>
			<div class="news">
				<img src="pictures/h2rating.png" alt="" class="rating-h">
				<div class="rating">
					<hr>
					<ul>
						<li class="first">Chicago Bulls</li>
						<li>Minesota Timberwolfs</li>
						<li>Los Angeles Lakers</li>
						<li>Huston Rockets</li>
						<li>Phinix Suns</li>
						<li>New York Nicks</li>
						<li>Washington Bullets</li>
						<li>New Jersey Nets</li>
						<li>Seatlle Supersonics</li>
					</ul>
				</div>
				<div class="banner">
					<div class="banner-header black-description">
						:: view detailed rating ::
					</div>
					<img src="pictures/h3banner.png" alt="" class="banner-h">
					<img src="pictures/banner-pict.png" alt="" class="banner-img">
				</div>
			</div>
			<div class="article">
				<img src="pictures/h2latestNews.png" alt="" class="article-h1">
				<div class="article-text">
					<?php
                        if (sizeof($_GET) > 0) {
                            echo '$_GET content:<br>';
                            foreach ($_GET as $key => $value) {
                                echo $key.' : '.$value.'<br>';
                            }
                        }
                        if (sizeof($_POST) > 0) {
                            echo '$_POST content:<br>';
                            foreach ($_POST as $key => $value) {
                                echo $key.' : '.$value.'<br>';
                            }
                        }
                        if (sizeof($_FILES) > 0) {
                            echo '$_FILES content:<br>';
                            foreach ($_FILES as $key => $value) {
                                echo $key.' : '.$value.'<br>';
                            }
                        }
                        if (sizeof($_SESSION) > 0) {
                            echo '$_SESSION content:<br>';
                            foreach ($_SESSION as $key => $value) {
                                echo $key.' : '.$value.'<br>';
                            }
                        }
                        if (sizeof($_COOKIE) > 0) {
                            echo '$_COOKIE content:<br>';
                            foreach ($_COOKIE as $key => $value) {
                                echo $key.' : '.$value.'<br>';
                            }
                        }
                        if (sizeof($_SERVER) > 0) {
                            echo '$_SERVER content:<br>';
                            foreach ($_SERVER as $key => $value) {
                                echo $key.' : '.$value.'<br>';
                            }
                        }
                    ?>
				</div>
				<div class="article-more">
						more..
				</div>

				<?php
					require_once "./php/article-games.html"
				?>
			</div>
			<?php
				require_once "./php/sponsors.html"
			?>
		</main>
		<footer>
			<div class="copy black-description">
				:: Copyright 2002 &nbsp-&nbsp All Rights Reserved © Lithuanian-American Basketball Association::
			</div>
			<div class="comp">
				Designed for labworks
			</div>
		</footer>
	</div>
</body>
</html>
