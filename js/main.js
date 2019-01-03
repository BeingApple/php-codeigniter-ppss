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
});