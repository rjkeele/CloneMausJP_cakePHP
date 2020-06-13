<script type="text/javascript">
	// Window Preview
	$("#PreviewBtn").click(function(e){
		e.preventDefault();
		var title = $("#ContentsTitle").val();
		var contents = $("#ContentsContent").val();
		var layout = $("input[name=layout]").val();
		if($("#addBr").is(':checked')){var add_br=1;}
		var url = "<?php echo URL; ?>";
		var form = $('<form></form>',{action:url+'/preview.php',target:'preview',method:'POST'}).hide();
		var body = $('body');
		body.append(form);
		form.append($('<input>',{type:'hidden',name:'title',value:title}));
		form.append($('<input>',{type:'hidden',name:'contents',value:contents}));
		form.append($('<input>',{type:'hidden',name:'layout',value:layout}));
		form.append($('<input>',{type:'hidden',name:'add_br',value:add_br}));
		window.open('about:blank'
					,'preview'
					,'menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes');
		form.submit();
		return false;
	});
</script>