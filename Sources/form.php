<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Labwork 4</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <script
            src="https://code.jquery.com/jquery-1.11.3.min.js"
            integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g="
            crossorigin="anonymous"></script>
	<script type="text/javascript" src="./js/animation.js"></script>
	<script type="text/javascript" src="./js/form.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("<div></div>", {
                id: "chk-div"
            }).appendTo("#regform");
            $("#chk-div").css("display", "flex").css("flex-direction", "column");
            for (var i = 0; i < 15; i++) {
                var label = "<label>Checkbox " + i + "</label>";
                var input = $(document.createElement("input"), {
                    type: "radio",
                    name: "j-query-chk",
                    value: i
                });
                ("#chk-div").append($input.after($label));

            }
        });
    </script>
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
                <form id="regform" name="regform" onsubmit="form.php" method="post">
                  <input type="text" name="name" placeholder="Имя" value="NickNAME1" autofocus>
                  <label for="username">Click me</label>
                  <div class="radioInput">
                     <input type="radio" name="gender" value="male" checked>Мужчина
                  </div>
                  <div class="radioInput">
                     <input type="radio" name="gender" value="female">Женщина
                  </div>
                  <fieldset>
                     <legend>Дата рождения</legend>
                     <input type="text" name="day" maxlength="2" size="4" placeholder="День" value="">
                     <input type="text" name="month" maxlength="2" size="4" placeholder="Месяц" value="">
                     <input type="text" name="year" maxlength="4" size="4" placeholder="Год" value="">
                  </fieldset>
                  <input id="reg-button" type="button" value="Зарегистрироваться">
                </form>
				</div>
				<div id="more" class="article-more">
                    
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
