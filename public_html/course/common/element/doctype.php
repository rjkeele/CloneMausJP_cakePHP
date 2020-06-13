<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Cyfons管理画面</title>
<script src="<?php echo URL; ?>/common/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/bootstrap-dropdown.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/jquery.dataTables.min.js" type="text/javascript" charset="utf8"></script>
<script src="<?php echo URL; ?>/common/js/jquery.selection.js"></script>
<script src="<?php echo URL; ?>/common/js/editer.js"></script>
<link href="<?php echo URL; ?>/common/css/jquery.dataTables.css" type="text/css" rel="stylesheet">
<link href="<?php echo URL; ?>/common/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="<?php echo URL; ?>/common/css/common.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function(){
	$('.dropdown-toggle').dropdown();	
	$('#table_id').dataTable( {
	"bPaginate": true,
	"bLengthChange": false,
	"bFilter": false,
	"bSort": false,
	"bInfo": true,
	"bAutoWidth": false,
	"bProcessing": true,
	"iDisplayLength": 50,
	"sPaginationType": "full_numbers",
	"oLanguage": {
		"sLengthMenu": "表示行数 _MENU_ 件",
		"oPaginate": {
		"sNext": "次のページ",
		"sPrevious": "前のページ",
		"sFirst": "最初",
		"sLast": "最後",
		},
		"sInfo": "全_TOTAL_件中 _START_件から_END_件を表示",
		"sSearch": "検索："
		},
	});
});
</script>
</head>
