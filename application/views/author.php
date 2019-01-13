<link href="/css/archives.css" rel="stylesheet" type="text/css">

<main>
    <!-- author -->
    <div class="author-description">
        <h1 class="author-title"><?php echo $header; ?></h1>
    </div>
    <!-- author end -->

    <?php 
        if(count($articleList) > 0){
            foreach($articleList as $index => $data){
    ?>
            <!-- article -->
            <article class="article author-article">
                <header class="article-header">
                    <h1 class="article-title">
                        <a class="article-title-link" href="/archives/<?php echo $data->ARTICLE_SEQ; ?>"><?php echo $data->ARTICLE_TITLE; ?></a>
                    </h1>
                    <p class="article-meta"> 
                        <time class="time" itemprop="datePublished" datetime="<?php echo $data->REG_DATE; ?>">
                            <?php echo date("Y년 n월 j일", strtotime($data->REG_DATE)); ?>
                        </time>
                        by <span class="article-author"><a href="<?php echo ($header == "전체글")?"/archives/author/$data->ADMIN_SEQ":"#"; ?>" class="article-author-link" rel="author"><?php echo $data->ADMIN_NAME; ?></a></span> 
                    </p>
                </header>

                <div class="article-content" >
                    <a href="/archives/<?php echo $data->ARTICLE_SEQ; ?>" class="article-image-link">
                        <img src="/uploads/ppss/article/<?php echo $data->ARTICLE_FILE_NAME; ?>" width="630" height="350" alt="<?php echo $data->ARTICLE_TITLE; ?>" itemprop="image">
                    </a>
                    <p>
                        <?php echo $data->ARTICLE_CONTENTS; ?>
                        <a href="/archives/<?php echo $data->ARTICLE_SEQ; ?>" class="more-link">[Read more...] <span class="screen-reader-text"><?php echo $data->ARTICLE_TITLE; ?></span></a></p>
                </div>
            </article>
            <!-- article end -->
    <?php
            }
        }
    ?>

    <!-- pagination -->
    <?php echo $pagination; ?>
    <!-- pagination end -->
</main>