$(document).ready(function(){
	 $(".menu-item").focusin(function(){
		 var submenu = $(this).children("ul");
		 if(submenu.length > 0){
			 submenu.css("z-index", "99999");
			 submenu.show();
			 submenu.children("li:last-child").focusout(function(){
				submenu.hide();
			 });
		 }
	});

	$(window).scroll(function(){
			var top = $("#banner-left").offset().top;
			var scrollTop = $(window).scrollTop();

			if(scrollTop > 240){
				$("#banner-left").css({"-webkit-transform":"translate(0px,"+(scrollTop-240) +"px)"});
				$("#banner-left").css({"-moz-transform":"translate(0px,"+(scrollTop-240) +"px)"});
				$("#banner-left").css({"-o-transform":"translate(0px,"+(scrollTop-240) +"px)"});
				$("#banner-left").css({"transform":"translate(0px,"+(scrollTop-240) +"px)"});
			}
	});

	$(".menu-btn > a").on("click", function(){
		var mobileMenu = $(".mobile-menu ul");

		if(mobileMenu.is(":visible")){
			mobileMenu.hide();
			$(this).css("border-bottom", "none");
		}else{
			mobileMenu.show();
			$(this).css("border-bottom", "1px solid #222");
		}
	});
});