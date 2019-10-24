<nav>
	<?php require '../includes/get-user.php' ?>
	<ul class="topnav">
		<li><a href="home.php">HOME</a></li>
		<?php if (isset($_SESSION['user']) and $user_name == 'admin') { ?>
		<li><a href="content-manager.php?mode=create_article">MANAGE CONTENT</a></li>
		<?php }?>
		<?php if (!isset($_SESSION['user'])) { ?>
		<li><a href="login.php">SIGN IN</a></li>
		<?php } else { 
		?>
		<li><a href="user.php"><?php echo $user['name'] ?></a></li>
		<?php } ?>
	</ul>
</nav>