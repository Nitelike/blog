<div class="post">
	<?php include '../includes/post-info.php' ?>
	<small class="text-part">
		<?php 
			$text_array = str_split(mb_substr(strip_tags($post['text']), 0, 255, 'utf-8'));
			if (count($text_array) >= 255) {
				$last_char = $text_array[count($text_array) - 1];
				$last_index = count($text_array);
				if (strpos('!.?', $last_char) !== false) {
					$last_index = count($text_array);
				}
				else if ((strpos(' ', $last_char) !== false)) {
					$last_index = count($text_array) - 1;
				}
				else {
					for ($i = $last_index - 1; $i > 0; $i--) {
						if (strpos('!.?', $text_array[$i]) !== false) {
							$last_index = $i + 1;
							break;
						}
						if ($text_array[$i] == ' ') {
							$last_index = $i;
							break;
						}
					}				
				}
				for ($i = 0; $i < $last_index; $i++) {
					echo $text_array[$i];
				}
				echo ' ...';
			}	
			else {
				for ($i = 0; $i < count($text_array); $i++) {
					echo $text_array[$i];
				}
			}		
		?>
	</small>
</div>