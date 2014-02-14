<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <title><?php include_slot('title')?></title>
    
	<script type="text/javascript">
		 $(document).ready( function () {
			$("body").css('visibility','visible');
		 });
	</script>
  </head>
  <body>
	  <div id="pageInstallFrame">
			<?php echo $sf_content ?>
	  </div>
  </body>
  
</html>