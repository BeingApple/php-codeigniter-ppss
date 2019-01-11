<link href="/css/archives.css" rel="stylesheet" type="text/css">

<!-- article -->
<article class="article">
    <header class="article-header">
        <h1 class="article-title"><?php echo $articleData->ARTICLE_TITLE; ?></h1>
        <p class="article-meta"> 
            <time class="time" itemprop="datePublished" datetime="<?php echo $articleData->REG_DATE; ?>">
                <?php echo date("Y년 n월 j일", strtotime($articleData->REG_DATE)) ?>
            </time>
            by <span class="article-author"><a href="#" class="article-author-link" rel="author"><?php echo $articleData->ADMIN_NAME; ?></a></span> 
        </p>
    </header>
    <div class="fb-like" data-href="https://ppss.kr/archives/183100" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true" style="margin-bottom:20px"></div>

    <div class="article-content" >
        <?php echo $articleData->ARTICLE_CONTENTS; ?>
    </div>

    <footer class="article-footer">
        <p class="article-meta">
            <span class="article-categories">Filed Under: <a href="" rel="category tag">음식</a></span> 
        </p>
    </footer>
</article>
<!-- article end -->

<!-- author box -->
<section class="article-author-box">
    <img src="/uploads/ppss/admin/<?php echo $writerData->ADMIN_FILE_NAME; ?>" class="author-img" alt="저자 이미지" />
    <h4 class="author-box-title">필자 
        <a href="/archives/author/<?php echo $writerData->ADMIN_SEQ; ?>"><strong><?php echo $writerData->ADMIN_NAME; ?></strong></a> 
        <?php if($writerData->ADMIN_BLOG != NULL && $writerData->ADMIN_BLOG != ""){ ?>
            <a href="<?php echo $writerData->ADMIN_BLOG; ?>" target="_blank">
                <img class="author-box-icon" width="20" height="20" alt="twitter" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHIAAAByCAYAAACP3YV9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzkyRUZCNkI4NEYwMTFFMjlCNTJDQzM3M0NDMDNGOTkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzkyRUZCNkM4NEYwMTFFMjlCNTJDQzM3M0NDMDNGOTkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozOTJFRkI2OTg0RjAxMUUyOUI1MkNDMzczQ0MwM0Y5OSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozOTJFRkI2QTg0RjAxMUUyOUI1MkNDMzczQ0MwM0Y5OSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PpiTaO4AAAt0SURBVHja7F15dFTl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">
            </a> 
        <?php } ?>
        <?php if($writerData->ADMIN_SNS != NULL && $writerData->ADMIN_SNS != ""){ ?>
            <a href="<?php echo $writerData->ADMIN_SNS; ?>" target="_blank">
                <img class="author-box-icon" width="20" height="20" alt="facebook" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAAA5CAYAAACMGIOFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDozQzlENkFERjZGNkJFMjExQURGQUY1MUU4RUMwRENENSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFODlEQTFEMzg0RjIxMUUyODVBNUJGOEY0QzdEMkRCNiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFODlEQTFEMjg0RjIxMUUyODVBNUJGOEY0QzdEMkRCNiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjdDQjlFNUJBRUQ4NEUyMTE4NDkwRkZDOTc1NDJBODI0IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjNDOUQ2QURGNkY2QkUyMTFBREZBRjUxRThFQzBEQ0Q1Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+h90TKQAAAnxJREFUeNrsm81LVFEYh98xrbwOlBV+LbJFSAyJ1PZWMClE4CLIFrlQsMAgI1qE4sapXW1aKFGRYAi6yD9Bc+M/EIauzAGTaQr6kMoWhv1e5x3x496ZiJkzc1/PD57NnXvnnueewz3vYc6E3OvPKEuqwDUQBU2gBoSpcPkBPoK3YBq8Bp8yXVCa4bMTIAbaQRkVT/gBnxSugidgTNoa97qgxOeLesAc6CwyQa+USTvnpN1ZJfeBl2AQlFOwUi7tHhYP3+H6AnRRsJNu/w2vnrytQHCraM9OSX7JPCZdeSRem5IPgKNM0hGvDclqmSY0hr2qWbIty3wZ5LBXG0teJN1pZslG5ZKN3J21pu529LBDrdFT5J6pp5pjYao85FAotP2cc+3Pc33b2lJTxfblCw10t8OlsLPfdE9WGHnhXDrfQP3d0V29Ziol+b7BEQzRe51uwQSNSF5pjhRiiP7zejIncc8e9zw+v/CZHj6doqXE9+BL1tdVeh6PDU3ScnJFx3A9eMD7OZoSNCJZDLGSmqr0nGZmrPu/z/u28ptab73S3ZPx5a/6h+viXpB8v/RFv+TeGK4f8tOTOX+77lz0+r1t87A4tsWAlbSSVtJKWkkraSWtpJW0klaySMJLLd6rlref70wuqXzyk3syobwjEyw5q1xyliXfKJecYskJsKZUkL0mWDIJxpVK8j7YZHoKGQC/lAmyT2zrPLkIepVJ9onXtmJgCIwoEWSPQb+K56YC0RHx8C3r/lBqQ+wdsBowuVVpd5d4ZKxd12XoRsBoAKaXNWlnRNq97lW7+iUOOsB9Sm0XbQGnKbUXr6KAUun/hbwDkzLPJzNd8FeAAQBYBHgnvr9xjwAAAABJRU5ErkJggg==">
            </a>
        <?php } ?>
    </h4>
    <div class="author-box-content" itemprop="description"><p><?php echo $writerData->ADMIN_DESC; ?></p></div>
</section>
<!-- author box end -->

<!-- ad widget -->
<div class="widget">
    <iframe width="100%" height="158" title="추천뉴스" frameborder="0" scrolling="no" name="dableframe-0.6063575070644462" style="border: 0px;" src="https://api.dable.io/widgets/id/KoEGJplB/users/37912712.1540882347875?from=https%3A%2F%2Fppss.kr%2Farchives%2F183100&amp;url=https%3A%2F%2Fppss.kr%2Farchives%2F183100&amp;ref=https%3A%2F%2Fppss.kr%2F&amp;cid=37912712.1540882347875&amp;uid=37912712.1540882347875&amp;site=ppss.kr&amp;id=dablewidget_KoEGJplB&amp;category1=%EC%9D%8C%EC%8B%9D&amp;ad_params=%7B%7D&amp;pixel_ratio=1&amp;client_width=630&amp;network=non-wifi&amp;lang=ko&amp;is_top_win=true&amp;top_win_accessible=1" data-ready="1"></iframe>
</div>

<div class="widget">
    <iframe width="100%" height="396" title="함께 보면 좋은 기사" frameborder="0" scrolling="no" name="dableframe-0.209729512939119" style="border: 0px;" src="https://api.dable.io/widgets/id/Ql9ZKOX4/users/37912712.1540882347875?from=https%3A%2F%2Fppss.kr%2Farchives%2F183100&amp;url=https%3A%2F%2Fppss.kr%2Farchives%2F183100&amp;ref=https%3A%2F%2Fppss.kr%2F&amp;cid=37912712.1540882347875&amp;uid=37912712.1540882347875&amp;site=ppss.kr&amp;id=dablewidget_Ql9ZKOX4&amp;category1=%EC%9D%8C%EC%8B%9D&amp;ad_params=%7B%7D&amp;item_id=183100&amp;pixel_ratio=1&amp;client_width=630&amp;network=non-wifi&amp;lang=ko&amp;is_top_win=true&amp;top_win_accessible=1" data-ready="1"></iframe>
</div>
<!-- ad widget -->

<!-- facebook comment -->
<section class="comments">
    <div class="fb-comments" data-href="https://ppss.kr/archives/183100" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
</section>
<!-- facebook comment end -->
