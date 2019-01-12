<link href="/css/main.css" rel="stylesheet" type="text/css">

<section id="container" class="container" tabIndex="0">
	<h3 class="widget-title">최신글</h3>
	<?php
		if(count($articleList) > 0){
			foreach($articleList as $index => $data){
	?>
			<!-- article -->
			<article class="article">
				<a href="#" class="thumb-link">
					<img src="<?php echo "/uploads/ppss/article/".$data->ARTICLE_FILE_NAME; ?>" alt="<?php echo $data->ARTICLE_TITLE ?> 썸네일" width="150" height="150" />
					<time class="time" itemprop="datePublished" datetime="<?php echo $data->REG_DATE; ?>">
						<?php echo date("Y년 n월 j일", strtotime($data->REG_DATE)); ?>
					</time>
				</a>
				<header class="article-header">
					<h4 class="article-title">
						<a href="/archives/<?php echo $data->ARTICLE_SEQ; ?>"><?php echo $data->ARTICLE_TITLE; ?></a>
					</h4>
					<p class="article-meta"> 
						by <span class="article-author"><a href="/archives/author/<?php echo $data->ADMIN_SEQ; ?>" class="article-author-link" rel="author"><?php echo $data->ADMIN_NAME; ?></a></span> 
					</p>
				</header>
				<div class="article-content">
					<?php echo $data->ARTICLE_CONTENTS; ?>
					<a href="/archives/<?php echo $data->ARTICLE_SEQ; ?>" class="show-more">더 보기</a>
				</div>
			</article>
			<!-- article end -->
	<?php
			}
		}
	?>
</section>

<!-- pagination -->
<section class="pagination">
	<a href="/archives/page/2" >전체글 더 보기</a>
</section>
<!-- pagination end -->