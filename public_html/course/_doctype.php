<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo ($data['title']) ? $data['title'].'&nbsp;|&nbsp;'.$data['site_name'] : $data['site_name'];?></title>
	<meta name="description" content="<?php echo $data['description']; ?>">
	<meta name="keywords" content="<?php echo $data['keyword']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/zerogrid.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/responsive.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">
	<?php echo (!empty($data['head'])) ? htmlspecialchars_decode($data['head']) : NULL; ?>
    <!--[if lt IE 9]>
		<script src="<?php echo URL; ?>/js/html5.js"></script>
		<script src="<?php echo URL; ?>/js/css3-mediaqueries.js"></script>
	<![endif]-->
</head>
