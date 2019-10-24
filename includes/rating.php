<?php
	require '../includes/config.php';
	if (!empty($_POST['mark-id'])) {
		if (isset($_SESSION['user'])) {
			$user_id = $_SESSION['user'];
			$user = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = $user_id");
			if (mysqli_num_rows($user) !== false) {
				$user = mysqli_fetch_assoc($user);
				$liked = $user['liked'];
				$disliked = $user['disliked'];

				$post_id = $_POST['mark-id'];
				$mark_type = $_POST['mark-type'];
				$art = mysqli_query($connection, "SELECT `likes`, `dislikes` FROM `articles` WHERE `articles`.`id` = $post_id");
				if (mysqli_num_rows($art) !== false) {
					$art = mysqli_fetch_assoc($art);
				}

				if ($mark_type == 1) {
					if (strpos($user['liked'], ' ' . $post_id . ',') === false and strpos($user['disliked'], ' ' . $post_id . ',') === false) {		
						$likes = $art['likes'] + 1;
						$to_like = mysqli_query($connection, "UPDATE `articles` SET `likes` = $likes WHERE `articles`.`id` = $post_id;");
						if ($to_like) {
							$liked = $liked . ' ' . $post_id . ',';
							if (!mysqli_query($connection, "UPDATE `users` SET `liked` = '$liked' WHERE `users`.`id` = $user_id;")) {
								echo mysqli_error($connection);
							}
							echo '&#5123; ' . $likes;
						}
					}
					else if (strpos($user['liked'], ' ' . $post_id . ',') !== false and strpos($user['disliked'], ' ' . $post_id . ',') === false) {
						$likes = $art['likes'] - 1;
						$to_like = mysqli_query($connection, "UPDATE `articles` SET `likes` = $likes WHERE `articles`.`id` = $post_id;");
						if ($to_like) {
							$liked = str_replace(' '. $post_id . ',', '', $liked);
							mysqli_query($connection, "UPDATE `users` SET `liked` = '$liked' WHERE `users`.`id` = $user_id;");
							echo '&#5123; ' . $likes;
						}
					}
					else if (strpos($user['liked'], ' ' . $post_id . ',') === false and strpos($user['disliked'], ' ' . $post_id . ',') !== false) {	
							$likes = $art['likes'];
							echo '&#5123; ' . $likes;
					}
				}
				else if ($mark_type == 0) {
					if (strpos($user['disliked'], ' ' . $post_id . ',') === false and strpos($user['liked'], ' ' . $post_id . ',') === false) {		
						$dislikes = $art['dislikes'] + 1;
						$to_dislike = mysqli_query($connection, "UPDATE `articles` SET `dislikes` = $dislikes WHERE `articles`.`id` = $post_id;");
						if ($to_dislike) {
							$disliked = $disliked . ' ' . $post_id . ',';
							mysqli_query($connection, "UPDATE `users` SET `disliked` = '$disliked' WHERE `users`.`id` = $user_id;");
							echo '&#5121; ' . $dislikes;
						}
					}
					else if (strpos($user['disliked'], ' ' . $post_id . ',') !== false and strpos($user['liked'], ' ' . $post_id . ',') === false) {
						$dislikes = $art['dislikes'] - 1;
						$to_dislike = mysqli_query($connection, "UPDATE `articles` SET `dislikes` = $dislikes WHERE `articles`.`id` = $post_id;");
						if ($to_dislike) {	
							$disliked = str_replace(' ' . $post_id . ',', '', $disliked);
							mysqli_query($connection, "UPDATE `users` SET `disliked` = '$disliked' WHERE `users`.`id` = $user_id;");		
							echo '&#5121; ' . $dislikes;
						}
					}
					else if (strpos($user['disliked'], ' ' . $post_id . ',') === false and strpos($user['liked'], ' ' . $post_id . ',') !== false) {
							$dislikes = $art['dislikes'];	
							echo '&#5121; ' . $dislikes;
					}					
				}
			}
		}
		else {
			$post_id = $_POST['mark-id'];
			$mark_type = $_POST['mark-type'];
			$art = mysqli_query($connection, "SELECT `likes`, `dislikes` FROM `articles` WHERE `articles`.`id` = $post_id");
			if (mysqli_num_rows($art) !== false) {
				$art = mysqli_fetch_assoc($art);
			}
			if ($mark_type == 1) {
				$likes = $art['likes'];
				echo '&#5123; ' . $likes;
			}
			else if ($mark_type == 0) {
				$dislikes = $art['dislikes'];	
				echo '&#5121; ' . $dislikes;
			}
		}	
	}
	mysqli_close($connection);
?>