<?php
	function setId($id) {
		$id = str_replace(' ', '', $id);
		$id = str_replace(',', '', $id);
		return $id;
	}

	function selectCategory($id, $connection) {	
		$id = setId($id);
		return (mysqli_fetch_assoc(mysqli_query($connection, "SELECT `title` FROM `categories` WHERE `id` = '$id'")))['title'];
	}

	function selectFromTable($table, $title, $mode)
	{	
		$counter = 0;
		require 'connect.php';
		$sql = "SELECT * FROM `$table`";	
		$result = mysqli_query($connection, $sql);	
		if (mysqli_num_rows($result) > 0) {
			while ($res = mysqli_fetch_assoc($result)) {
				if ($table == 'categories') {
					if (strpos(mb_strtolower($res['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($res['description']), mb_strtolower($title)) !== false) {
						echo "<div><a href='content-manager.php?mode=$mode"."_category&id=$res[id]'>$res[title]</a>, категория</div> <br>";
						$counter++;
					}	
				}
				else if ($table == 'articles') {
					if (strpos(mb_strtolower($res['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($res['text']), mb_strtolower($title)) !== false) {
							echo "<div>
								<a href='content-manager.php?mode=$mode"."_article&id=$res[id]'>$res[title]</a>, статья";

							echo "</div> <br>";
							
						$counter++;
					}
				}
				else if ($table == 'districts') {
					if (strpos(mb_strtolower($res['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($res['description']), mb_strtolower($title)) !== false) {
						echo "
						<div>
							<a href='content-manager.php?mode=$mode"."_district&id=$res[id]'>$res[title] область</a>
						</div> <br>";
						;
						$counter++;
					}	
				}		
			}
		}
		return $counter;
	}

	function selectForDelete($table, $title) {
		$counter = 0;
		require 'connect.php';
		$sql = "SELECT * FROM `$table`";	
		$result = mysqli_query($connection, $sql);	
		if (mysqli_num_rows($result) > 0) {
			while ($res = mysqli_fetch_assoc($result)) {
				if ($table == 'categories') {
					if (strpos(mb_strtolower($res['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($res['description']), mb_strtolower($title)) !== false) {
						echo '<div>';
						echo "<input class='delete-option' name='delete_cat[]' type='checkbox' value='$res[id]'>";
						echo "<a href='category.php?cat=$res[id]'>$res[title]</a>, категория";
						echo '</div> <br>';
						$counter++;
					}	
				}
				else if ($table == 'articles') {
					if (strpos(mb_strtolower($res['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($res['text']), mb_strtolower($title)) !== false) {
						echo '<div>';
						echo "<input class='delete-option' name='delete_art[]' type='checkbox' value='$res[id]'>";
						echo "<a href='article.php?id=$res[id]'>$res[title]</a>, статья";
						echo '</div> <br>';
						$counter++;
					}
				}
				else if ($table == 'districts') {
					if (strpos(mb_strtolower($res['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($res['description']), mb_strtolower($title)) !== false) {
						echo '<div>';
						echo "<input class='delete-option' name='delete_dis[]' type='checkbox' value='$res[id]'>";
						echo "<a href='district.php?id=$res[id]'>$res[title] область</a>";
						echo '</div> <br>';
						$counter++;
					}	
				}		
			}
		}
		return $counter;
	}
