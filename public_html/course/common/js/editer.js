/*! Contents Builder 2013 */
$(function(){
	// Wrap wrap-xx-large tag
	$('#wrap-xx-large').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<span style="font-size:large;">', mode: 'before'})
		.selection('insert', {text: '</span>', mode: 'after'});
	});
	// Wrap wrap-x-small tag
	$('#wrap-x-small').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<span style="font-size:x-small;">', mode: 'before'})
		.selection('insert', {text: '</span>', mode: 'after'});
	});
	// Wrap wrap-bold tag
	$('#wrap-bold').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<span style="font-weight:bold;">', mode: 'before'})
		.selection('insert', {text: '</span>', mode: 'after'});
	});
	// Wrap wrap-red tag
	$('#wrap-red').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<span style="color:#FF0000;">', mode: 'before'})
		.selection('insert', {text: '</span>', mode: 'after'});
	});
	// Wrap wrap-left tag
	$('#wrap-left').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<div style="text-align:left;">', mode: 'before'})
		.selection('insert', {text: '</div>', mode: 'after'});
	});
	// Wrap wrap-right tag
	$('#wrap-right').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<div style="text-align:right;">', mode: 'before'})
		.selection('insert', {text: '</div>', mode: 'after'});
	});
	// Wrap wrap-center tag
	$('#wrap-center').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<div style="text-align:center;">', mode: 'before'})
		.selection('insert', {text: '</div>', mode: 'after'});
	});
	// Wrap wrap-list1 tag
	$('#wrap-list1').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<ul><li>', mode: 'before'})
		.selection('insert', {text: '</li></ul>', mode: 'after'});
	});
	// Wrap wrap-list2 tag
	$('#wrap-list2').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<li>', mode: 'before'})
		.selection('insert', {text: '</li>', mode: 'after'});
	});
	// Wrap strong tag
	$('#wrap-strong').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<strong>', mode: 'before'})
		.selection('insert', {text: '</strong>', mode: 'after'});
	});
	// Wrap blockquote tag
	$('#wrap-blockquote').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<blockquote>', mode: 'before'})
		.selection('insert', {text: '</blockquote>', mode: 'after'});
	});
	// Wrap link1 tag
	$('#wrap-link1').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<a href="', mode: 'before'})
		.selection('replace', {text: 'http://'})
		.selection('insert', {text: '">'+ selText + '</a>', mode: 'after'});
	});
	// Wrap link2 tag
	$('#wrap-link2').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<a href="', mode: 'before'})
		.selection('replace', {text: 'http://'})
		.selection('insert', {text: '" target="_blank">'+ selText + '</a>', mode: 'after'});
	});
	// Wrap img tag
	$('#wrap-img').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<img src="', mode: 'before'})
		.selection('replace', {text: ''})
		.selection('insert', {text: '" alt="'+ selText + '" />', mode: 'after'});
	});	// Wrap ins tag
	$('#wrap-ins').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<ins>', mode: 'before'})
		.selection('insert', {text: '</ins>', mode: 'after'});
	});
	// Wrap marker tag
	$('#wrap-marker').click(function(e){
		e.preventDefault();
		var selText = $('#ContentsContent').selection();
		$('#ContentsContent')
		.selection('insert', {text: '<span style="background-color:#ffff00;">', mode: 'before'})
		.selection('insert', {text: '</span>', mode: 'after'});
	});
	// Realtime Preview
	$("#ContentsContent").bind("click keyup", function(e){
		var txtVal = $("#ContentsContent").val();
		txtVal = txtVal.replace(/\r\n/g, "<br />");
		txtVal = txtVal.replace(/(\n|\r)/g, "<br />");
		txtVal = txtVal.replace(/<script/g, "&lt;script");
		txtVal = txtVal.replace(/<\/script>/g, "&lt;/script&gt;");
		txtVal = txtVal.replace(/<\?php/g, "&lt;?php");
		$("#preview").html(txtVal);
	});
});
