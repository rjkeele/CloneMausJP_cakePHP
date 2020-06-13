<?php
	require_once( 'config.ini' );
	require_once( 'users.php' );
	require_once( 'builders.php' );
	require_once( 'class_image.php' );

	$usersObj = new users();
	$buildersObj = new builders();

	$upload_key = 'images';
	$img_path1 = 'images';
	$img_path2 = date( "Ymd", time() );
	$img_path = '../'.$img_path1.'/'.$img_path2;
	
	if( !is_dir( $img_path ))
	{
		if( @mkdir( $img_path ))
		{
			// err
		} else {
			$err['upload'] = 'ディレクトリの作成に失敗しました。';
		}
	}
	
	$result = $buildersObj->upload( $data, $upload_key, $img_path );
	if( $result === TRUE)
	{
		$data['title'] = pathinfo( $data['org_file'], PATHINFO_FILENAME );
		$data['store_folder'] = $img_path1.'/'.$img_path2;
		$data['thumbnail'] = 'thum-'.$data['store_file'];
		
		$buildersObj->db_add_img_uploaders( $data );
		$data['store_folder'] = '../'.$data['store_folder'];
		$buildersObj->make_thumbnail( $data );
	} else {
		$err['upload'] = $result;
		$buildersObj->get_all_img_uploaders( $img_uploaders_data );
		echo '<p style="color:#ff0000">'.$err['upload'].'</p>';
		return;
	}

	$buildersObj->get_all_img_uploaders( $img_uploaders_data );


?>

<ul id="img_uploaders_area" class="thumbnails">
<?php foreach( $img_uploaders_data as $col ): ?>
<?php if($col['thumbnail']): ?>
<li class="span1">
<a href="<?php echo URL.'/'.$col['store_folder'].'/'.$col['store_file']; ?>" class="thumbnail" target="_blank"><img src="<?php echo URL.'/'.$col['store_folder'].'/'.'c-'.$col['thumbnail']; ?>" alt="<?php echo $col['title'];?>"></a>
<a id="img-<?php echo $col['id']?>" href="#">選択</a>
<script type="text/javascript">
$(function(){
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
