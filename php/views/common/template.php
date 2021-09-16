<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />

		<!-- Meta Data -->
		<title>Project Unamed 1544</title>
		<meta name="description" content="" />

		<!-- Critical style -->
		<style>
			* {
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}

			html,
			body {
				margin: 0;
				padding: 0;
				height: 100%;
				width: 100%;
			}

			#preloader {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				display: flex;
				align-items: center;
    		justify-content: center;
			}
		</style>

		<!-- Style -->
		<link rel="stylesheet" href="/static/css/style.css" />

		<meta name="viewport" content="initial-scale=1" />
	</head>

	<body>
		<div id="preloader" class="show">
			<div>
				<i class="fas fa-circle-notch fa-spin"></i>
				Loading...
			</div>
		</div>

		<div id="content">
			<?php isset($viewPath) ? include_once VIEWS_DIR . "/${viewPath}.php" : '' ?>
		</div>

		<footer></footer>

		<!-- JS -->
		<?php
			if(file_exists(BASE_DIR . '/static/js/bundle.js')) {
				echo '<script type="module" src="/static/js/bundle.js"></script>';
			} else {
				echo '<script type="module" src="/static/js/routing.js"></script>';
			}
		?>
		<script type="module" src="/static/js/routing.js"></script>
	</body>
</html>
