<nav>
	<?php require '../includes/get-user.php' ?>
	<ul class="topnav">
		<li><a href="home.php">ГЛАВНАЯ</a></li>
		<?php if (isset($_SESSION['user']) and $user_name == 'admin') { ?>
		<li><a href="content-manager.php?mode=create_article">УПРАВЛЕНИЕ КОНТЕНТОМ</a></li>
		<?php }?>
		<?php if (!isset($_SESSION['user'])) { ?>
		<li><a href="login.php">ВХОД</a></li>
		<?php } else { 
		?>
		<li><a href="user.php"><?php echo $user['name'] ?></a></li>
		<?php } ?>
		<?php if (isset($_SESSION['user'])) {?>
		<li><a href="<?php echo $user_icon ?>" target="_blank"><img src="<?php 
			if ($user_icon != null) {
				echo $user_icon;
			}
			else {
				echo '../images/user.png';
			}
		?>" alt="icon" class="icon"></a></li>
	<?php }
		if (strpos($_SERVER['REQUEST_URI'], 'home') !== false) { ?>
		<li><button id="menu-icon" class="send-button" type="button" onclick="showMenu()"><span>&#9776;</span></button></li>
	<?php } ?>
	</ul>
</nav>