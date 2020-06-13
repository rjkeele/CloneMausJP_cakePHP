<?php if(is_array($img_uploaders_data)):?>
<ul id="img_uploaders_area" class="thumbnails">
<?php foreach( $img_uploaders_data as $col ): ?>
<?php if($col['thumbnail']): ?>
<li class="span1">
<a href="<?php echo URL.'/'.$col['store_folder'].'/'.$col['store_file']; ?>" class="thumbnail" target="_blank"><img src="<?php echo URL.'/'.$col['store_folder'].'/'.'c-'.$col['thumbnail']; ?>" alt="<?php echo $col['title'];?>"></a>
<a id="img-<?php echo $col['id']?>" href="#">選択</a>

<script type="text/javascript">
$(function(){
	// Wrap img tag
	$('#img-<?php echo $col['id']?>').click(function(e){
		 e.preventDefault();
		
		var selText = $('#ContentsContent').selection();
		 
		$('#ContentsContent')
		.selection('insert', {text: '<img src="', mode: 'before'})
		.selection('replace', {text: '<?php echo URL.'/'.$col['store_folder'].'/'.$col['store_file']; ?>'})
		.selection('insert', {text: '" alt="'+ selText + '" />', mode: 'after'});
	});
});
</script>

</li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
