// JavaScript Document



//ALL Load

$(function(){

	RollOverSetg();
	RollOverSetj();
	RollOverSetc();
	RollOverSetp();

	PageTopSet();

	SearchChange();

	TitleChange();

	ItemChange();

if(document.getElementById("tokuori")){

	Oritoku();

}

});



function Oritoku(){

$(document).ready(function(){

$(".oritoku").each(function(){

    jQuery(this).find("li:odd").addClass("right");

  });

});

}



//RollOver

function RollOverSetg(){

	RollOverg(".b_mlogin");

	RollOverg(".b_detail");

	RollOverg(".b_entry_mem");

	RollOverg(".leftbox .search_list");

	RollOverg(".b_guide");

	RollOverg(".hover_g");

}

function RollOverg(target){

	$target = $(target);

	$("img", $target).each(function(){

		$(this).mouseover(function(){

			this.setAttribute("src", this.getAttribute("src").replace(".gif", "_on.gif"));

        })

		$(this).mouseout(function(){

			this.setAttribute("src", this.getAttribute("src").replace("_on.gif", ".gif"));

        })

		$(".stay").unbind();

	});

}



function RollOverSetj(){

	RollOverj(".hover_j");

}

function RollOverj(target){

	$target = $(target);

	$("img", $target).each(function(){

		$(this).mouseover(function(){

			this.setAttribute("src", this.getAttribute("src").replace(".jpg", "_on.jpg"));

        })

		$(this).mouseout(function(){

			this.setAttribute("src", this.getAttribute("src").replace("_on.jpg", ".jpg"));

        })

		$(".stay").unbind();

	});

}



function RollOverSetc(){

	RollOverc(".hover_c");

}

function RollOverc(target){

	$target = $(target);

	$("input", $target).each(function(){

		$(this).mouseover(function(){

			this.setAttribute("src", this.getAttribute("src").replace(".jpg", "_on.jpg"));

        })

		$(this).mouseout(function(){

			this.setAttribute("src", this.getAttribute("src").replace("_on.jpg", ".jpg"));

        })

		$(".stay").unbind();

	});

}


function RollOverSetp(){
	RollOverp(".hover_p");
}

function RollOverp(target){
	$target = $(target);
	$("img", $target).each(function(){
		$(this).mouseover(function(){
			this.setAttribute("src", this.getAttribute("src").replace(".png", "_on.png"));
        })
		$(this).mouseout(function(){
			this.setAttribute("src", this.getAttribute("src").replace("_on.png", ".png"));
        })
		$(".stay").unbind();
	});
}

function PageTopSet(){

	PageTop("#link_to_top","#wrapper");
	PageTop(".link_to_toc0","#toc0");
	PageTop(".link_to_toc1","#toc1");
	PageTop(".link_to_toc2","#toc2");
	PageTop(".link_to_toc3","#toc3");
	PageTop(".link_to_toc4","#toc4");
	PageTop(".link_to_toc5","#toc5");
	PageTop(".link_to_toc6","#toc6");
	PageTop(".link_to_toc7","#toc7");
	PageTop(".link_to_toc8","#toc8");
	PageTop(".link_to_toc9","#toc9");
	PageTop(".link_to_toc10","#toc10");

	}

function PageTop(target,target2){

$(function () {

		$target = $(target);	

		$target2 = $(target2);	

        $($target).click(function () {

			$(this).blur();

			var targetOffset = $(target2).offset().top;



            $('html,body').animate({ scrollTop: targetOffset }, 'slow');



            return false;

        });

});

}





function SearchChange(){

$("#b_csr").click(function(){

$("#item_sf").slideToggle("300");

$(this).toggleClass("on");

});

//$(".textinp").focus(function(){
//$("#item_sf").slideDown("300");
//$("#b_csr").addClass("on");
//});


$("#other_address_csr").click(function(){

$("#other_address_sf").slideToggle("300");

});

$("#pay2_csr").click(function(){

$("#pay2_sf").slideToggle("300");

});

$("#pay3_csr").click(function(){

$("#pay3_sf").slideToggle("300");

});

$("#pay4_csr").click(function(){

$("#pay4_sf").slideToggle("300");

});

$("#pay6_csr").click(function(){

$("#pay6_sf").slideToggle("300");

});

$("#pay7_csr").click(function(){

$("#pay7_sf").slideToggle("300");

});

$("#pay8_csr").click(function(){

$("#pay8_sf").slideToggle("300");

});

$("#inquiry_csr_1").click(function(){

$("#inquiry_sf_1").slideDown("300");

$("#inquiry_sf_2").slideUp("300");

$("#inquiry_sf_3").slideUp("300");

});

$("#inquiry_csr_2").click(function(){

$("#inquiry_sf_2").slideDown("300");

$("#inquiry_sf_1").slideUp("300");

$("#inquiry_sf_3").slideUp("300");

});

$("#inquiry_csr_3").click(function(){

$("#inquiry_sf_3").slideDown("300");

$("#inquiry_sf_1").slideUp("300");

$("#inquiry_sf_2").slideUp("300");

});

    $('input[type=radio]').change(function() {
        $('#tr1,#tr2,#tr3,#tr4,#tr5,#tr6').removeClass('invisible');
        if ($('#subject0').is(':checked')) {
            $('#tr2,#tr4,#tr5').addClass('invisible');
        } else if($('#subject1').is(':checked')) {
            $('#tr1,#tr2').addClass('invisible');
        } else if($('#subject2').is(':checked')) {
            $('#tr1,#tr3,#tr4').addClass('invisible');
        } else if($('#subject3').is(':checked')) {
            $('#tr1,#tr3,#tr4').addClass('invisible');
        } else if($('#subject4').is(':checked')) {
            $('#tr1,#tr3,#tr4').addClass('invisible');
        } else if($('#subject5').is(':checked')) {
            $('#tr1,#tr2').addClass('invisible');
        } else {
            $('#tr1,#tr2,#tr3,#tr4,#tr5,#tr6').addClass('invisible');
        }
    }).trigger("change");

}



function TitleChange(){

$('#hover').find('li').hover(function(){

$(this).find('ul.enter').show();

}, function(){

$(this).find('ul.enter').hide();

});

}



function ItemChange(){

$("#t_ne").click(function(){

$(".neitemlist").fadeIn("normal");

$(".pcitemlist").fadeOut("normal");

});

$("#t_pc").click(function(){

$(".neitemlist").fadeOut("normal");

$(".pcitemlist").fadeIn("normal");

});

}



$(function(){

    $("span.tooltip").css("opacity","0.9").hide();

    $(".searchbox .textinp").focus(function(){

        $("span.tooltip").slideDown("fast");

    }).blur(function(){

        $("span.tooltip").slideUp("fast");

    });

});

//TOPへ戻るボタン 20150519
$(function(){
	//ボタン[id:page-top]を出現させるスクロールイベント
	$(window).scroll(function(){
		//最上部から現在位置までの距離を取得して、変数[now]に格納
		var now = $(window).scrollTop();

		//最下部から現在位置までの距離を計算して、変数[under]に格納
		var under = $('body').height() - (now + $(window).height());
 
		//最上部から現在位置までの距離(now)が500以上かつ
		//最下部から現在位置までの距離(under)が100px以上だったら
		if(now > 200){
			//[#page-top]をゆっくりフェードインする
			$('#page-top').fadeIn('slow');
		//それ以外だったらフェードアウトする
		}else{
			$('#page-top').fadeOut('slow');
		}
	});
 
	//ボタン(id:move-page-top)のクリックイベント
	$('#move-page-top').click(function(){
		//ページトップへ移動する
		$('html,body').animate({scrollTop:0},'slow');
	});
});