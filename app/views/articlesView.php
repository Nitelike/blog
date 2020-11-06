<?php if($data['search'] == 'false') { ?>

<section class="right">
	<span class="title">Подкатегории</span>
	<hr>

	<?php foreach ($data['subcategories'] as $subcategory) { ?>
		<a class="line-link common-link" href="<?=$data['path']?>/public/articles/subcategory/<?=$subcategory['id']?>"><?=$subcategory['title']?></a>
	<?php } ?>
</section>

<?php } ?>

<section class="articles-previews <?php if($data['search'] == 'false') { echo 'left'; } ?>">

	<?php foreach($data['articles'] as $article) { ?>

	<div class="article-preview">
		<a href="<?=$data['path']?>/public/article/read/<?=$article['id']?>"><div class="image-container" style="background-image: url(<?=$article['src']?>);"></div></a>
		<a class="common-link title" href="<?=$data['path']?>/public/article/read/<?=$article['id']?>"><?=$article['title']?></a>
	</div>

	<?php } ?>

</section>