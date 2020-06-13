<div id="img_uploaders_div">
	<form id="img_uploaders_form" accept-charset="utf-8" method="post" enctype="multipart/form-data" id="ImgUploadersForm" class="form-inline">
	<input class="input-file" id="ImgUploaders" type="file" name="images">
	<button id="img_upload_btn" type="submit" class="btn btn-primary" style="margin-right:5px;">アップロード</button>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$("#img_uploaders_form_area")
	.css("height", "30px");
	$("#img_uploaders_div")
	.css("position", "relative");
	
	$("#img_uploaders_form")
	.css("position", "absolute")
	.css("top", "-225px")
	.css("left", "160px");
	
	$("#img_uploaders_form").submit(function(e) {
		e.preventDefault();
		e.stopPropagation();

		var $form = $(this);
		var fd = new FormData($form[0]);
		var url = "<?php echo URL ?>";
		
		$.ajax(url+'/common/ajax_upload.php', {
			type: 'post',
			processData: false,
			contentType: false,
			data: fd,
			dataType: 'html',
			success: function(data){
				console.log(data);
				$("#ajax_img_upload_area").html(data);
			}
		});
		return false;
	});
});
</script>
