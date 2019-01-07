<!DOCTYPE html>
<html>
 <head>
	<title><?php echo $vars['title'] ?></title>
	<meta charset="UTF-8">
	<meta name="Generator" content="EditPlus">
	<meta name="Author" content="조용비">
	<meta name="Description" content="필자와 독자의 경계가 없는 이슈 큐레이팅 매거진">
	<meta name="robots" content="noodp,noydir">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="icon" href="/images/ppss-100x100.png" sizes="32x32">
	<link rel="icon" href="/images/ppss.png" sizes="192x192">
	<link href="/css/common.css" rel="stylesheet" type="text/css">
 </head>

 <body>
    <div id="fb-root"></div>
	<!-- skip -->
	<div class="skip">
		<a href="#container">본문으로 바로가기</a>
	</div>
	<!-- skip end -->

	<div class="site-container" >
		<!-- header -->
		<header>
			<div class="wrap">
				<div class="title">
					<a href="#"><img src="/images/title.png" alt="ㅍㅍㅅㅅ 타이틀"></a>
				</div>
			</div>
		</header>
		<!-- header end -->

		<!-- nav -->
		<?php $this->view($nav, $vars); ?>
		<!-- nav end -->

		<!-- main -->
		<main class="wrap">
			<!-- 광고!!!!!!!!!!!!!!!!! -->
			<div id="banner-left" class="wing-banner">
				<iframe name="ifrad" width="160" height="600" id="ifrad" src="https://www.dreamsearch.or.kr/servlet/adBanner?from=&amp;u=2018010200010&amp;us=16451&amp;s=17230&amp;iwh=160_600&amp;igb=69&amp;cntsr=3" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
			</div>
            
            <div class="content_wrap">
                <?php $this->view($template_name, $vars); ?>
            </div>
            
            <!-- aside -->
			<?php $this->view($aside, $vars); ?>
            <!-- aside end -->
		</main>
		<!-- main end -->

		<!-- footer -->
		<?php $this->view($footer, $vars); ?>
		<!-- footer end -->
	</div>
 </body>
 <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
 <script src="/js/main.js"></script>
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 <script>
	(adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-4647520150708391",
		enable_page_level_ads: true
	});
</script>
<script>
	WebFontConfig = {
		google: {
			families: ['Nanum Gothic:300,400']
		}
	};
	(function(d) {
		var wf = d.createElement('script'), s = d.scripts[0];
		wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
		wf.async = true;
		s.parentNode.insertBefore(wf, s);
	})(document);
	</script>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-37439162-2', 'auto');
		ga('send', 'pageview');
</script>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v3.2&appId=471490042886980&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</html>
