<section class="left">
	<div class="msg-success"><?=$data['response']['success'][0]?></div>
	<div class="msg-alert"><?=$data['response']['errors'][0]?></div>
	<form method="post" action="<?=$data['path']?>/public/article/<?=$data['action']?>">
		<span class="title"><?=$data['page']?></span>
		<hr>

		<textarea class="textarea-title" name="title" placeholder="Название" required="true" autocomplete="off" maxlength="150"><?=$data['article']['title']?></textarea>

		<div class="editor-buttons-row">
			<button type="button" onclick="add('<b></b>')"><b>B</b></button>
			<button type="button" onclick="add('<i></i>')"><i>I</i></button>
			<button type="button" onclick="add('<u></u>')"><u>U</u></button>
			<button type="button" onclick="add('<s></s>')"><s>S</s></button>
			<button type="button" onclick="add('<small></small>')"><small>small</small></button>
			<button type="button" onclick="add('<big></big>')"><big>BIG</big></button>
			<button type="button" onclick="add('<h2></h2>')">h2</button>
			<button type="button" onclick="add('<p></p>')">p</button>
			<button type="button" onclick='add("<img src=\"\" alt=\"\">")'>img</button>
			<button type="button" onclick='add("<a href=\"\"></a>")'>link</button>
		</div>
		<textarea id="text" class="textarea-text" name="text" placeholder="Текст" required="true" autocomplete="off"><?=$data['article']['text']?></textarea>
		
		<section class="article preview">
			<div id="preview" class="content">
				
			</div>
		</section>

		<label for="category">Категория</label>
		<br>
		<select name="category">
			<?php foreach ($data['categories'] as $category) { ?>
				<option <?php if(strpos($data['article']['category'], ' ' . $category['id'] . ',') !== false) echo 'selected'; ?> value="<?=$category['id']?>"><?=$category['title']?></option>
			<?php } ?>
		</select>
		<br> <br>

		<label for=""><a class="common-link" href="https://www.gpsies.com/coordinate.do?language=ru" target="blank">Координаты</a> обекта</label>
		<br>
		<input type="text" name="lat" placeholder="Широта" value="<?=$data['article']['lat']?>" autocomplete="off">
		<input type="text" name="lng" placeholder="Долгота" value="<?=$data['article']['lng']?>" autocomplete="off">
		<br> <br>

		<button class="btn" type="submit">Отправить</button>
	</form>
</section>

<script defer src="<?=$data['path']?>/public/js/articleEditor.js"></script>	