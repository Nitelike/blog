<section class="articles-previews">

    <?php
        if(!$data['articles'])
            echo("<span class=\"title\">Нет статей</span>");
    ?>

	<?php foreach($data['articles'] as $article) { ?>

	<div class="article-preview">
		<a href="<?=$data['path']?>/public/article/read/<?=$article['id']?>"><div class="image-container" style="background-image: url(<?=$article['src']?>);"></div></a>
		<a class="common-link title" href="<?=$data['path']?>/public/article/read/<?=$article['id']?>"><?=$article['title']?></a>
	</div>

	<?php } ?>

</section>