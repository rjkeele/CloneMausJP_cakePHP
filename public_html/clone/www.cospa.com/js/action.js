

/** tooltip表示 **/

$(function(){
    $("div.tooltip").css("opacity","1").hide();
    $(".textinp").focus(function(){
        $("div.tooltip").slideDown("fast");
    })
});

function closetool(){
        $("div.tooltip").slideUp("fast");
    };


/** footer **/

$(function() {
  $('.footer-links-holder h3').click(function () {
    $(this).parent().toggleClass('active');
  });
});