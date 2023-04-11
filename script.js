function ask(){
	var question = confirm("You Are About TO LOGOUT. Click OK If You Consent.");
	if(question == true){
		window.location.href = "../lib/logout";
	}else{
		alert("Okay Then, Let\'s Continue !!!");
	}
}



function motion(){
	setTimeout("$('.pic2').hide(1000);$('.pic3').hide(1000); $('.pic1').show(1000);",1000);
	setTimeout("$('.pic1').hide(); $('.pic3').hide(1000); $('.pic2').show(1000);",5000);
	setTimeout("$('.pic1').hide(); $('.pic2').hide(1000); $('.pic3').show(1000);",9000);
}



function stomach(){
	setTimeout("$('.service').hide(2000);$('.service1').hide(2000);",1000);
	setTimeout("$('.service').show(2000);",6000);
	setTimeout("$('.serv').hide(2000);$('.service1').hide(2000);",6000);
	setTimeout("$('.service').hide(2000);$('.serv').hide(2000);",11000);
	setTimeout("$('.service1').show(2000);",11000);
	setTimeout("$('.service').hide(2000);$('.service1').hide(2000);",16000);
	setTimeout("$('.serv').show(2000);",16000);
}

$(document).ready(function(){
	//$(".index").text("Welcome To Asbesoc And Vpad Online Base");
	
//////////////thei code here handles the introductory page////////////////////////////////////////////////
	$(".index_img").show(5000);
	$(".one").show(1000);
	$(".two").show(3000);
	$(".three").show(5000);
	$(".four").show(7000);
	$(".five").show(10000);
	setTimeout("$('.name').css('color','white');",10000);
	
////////////////this is here is handling the navigation bar slideUp, slideDown and on scroll function////////////////////////////////////////
	$(".li").slideUp(1);
	$(".menu,.a").on("click",function(){
		$(".li").toggle(2000);
	});
	
	$(this).on("scroll",function(){
		$(".nav").css({"position":"fixed","top":"0","left":"0","z-index":"100"});
	});
	
	
	
////////////this code handles the animation of the service area(stomach)///////////////////////
	setInterval("stomach()",16000);
	
	
////////////////page loading handler onclick/////////////////////////////////
	$("div ul li a").on("click",function(){
		var page = $(this).attr("href");
		$(".content").load(page +".php");
		$(this).css({"background-color":"blue"});
		
		return false;
		
	});
	

//////////////////////////login and registration form display handler/////////////////////////////
	$(".login0").on("click",function(){
		$(".register").hide(1500);
		$(".login").show(2000);
		$(this).hide(2000);
		$(".register0").show(1500);
	});
	
	$(".register0").on("click",function(){
		$(".login").hide(1500);
		$(".register").show(2000);
		$(this).hide(2000);
		$(".login0").show(1500);
	});
	
	
	/////////// THIS CODE CONTROLS THE SPINER ////////////
	$('.a, .button, .input,.spin,.a2').click(function(){
		$('#loading').show();
		setTimeout("$('#loading').hide();",3000);
    });
	
	///////////image animation hadler
	setInterval("motion();",13000);
	
	
	
	
	///////////////profile pics section handler/////////////////////////////
	$(".change").on("click",function(){
		$(".change-form").toggle();
		$(this).hide();
	});
	
	
	$(".end").on("click",function(){
		$(".change-form").toggle();
		$(".change").show();
	});
	
	
	
});




$(window).on("load",function(){
	setTimeout("$('#loading').hide();",3000);
});