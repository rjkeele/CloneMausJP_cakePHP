<!--------------Doctype--------------->
<?php include("_doctype.php"); ?>
<!--------------Header--------------->
<?php include("_header.php"); ?>
<!--------------Content--------------->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">
<div id="main-content" class="col-2-3">
<div class="wrap-col">
<article>
<div class="heading">
<h2><?php echo $data['title'] ?></h2>
<div class="info"></a></div>
</div>
<div class="content">
<!--------------Page original start--------------->
<?php echo $data['contents']; ?>
<!--------------Page original end--------------->
</div>
</article>
</div>
</div>
<!--------------sidebar pagelist start--------------->
<?php include("_sidebar.php"); ?>
</div>
</div>
</section>
<!--------------Footer--------------->
<?php include("_footer.php"); ?>