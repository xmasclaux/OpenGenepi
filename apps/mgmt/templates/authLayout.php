<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    
    <script type="text/javascript">
    $(document).ready( function () {
		$("body").css('visibility','visible');
    });
	</script>
    
    <title><?php include_slot('title')?></title>
  </head>
  <body>
	<div id="ban"></div>
	<div id="menus">
		<div id="mainMenu">
			<span id="topLeftLogo">
				<?php echo image_tag('/uploads/images/logo.png?'.microtime(), array('height' => '90')) ?>
			</span>
		</div>	
	</div>
	<div id="pageFrame">
		<span id="feedbackFrame"><?php include_slot('feedbackFrame') ?></span>
		<?php echo $sf_content ?>	
	</div>
	<div id="footer"> </div>
  </body>
</html>