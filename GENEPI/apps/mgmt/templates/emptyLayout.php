<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    
    
    <?php 
    //This class will used in order to define MainMenu icons, depending on user credentials
    define('USERS_AUTH',dirname(__FILE__).'/../modules/auth/lib/usersAuth.class.php');
	require_once(USERS_AUTH);
	?>

    <title><?php include_slot('title')?></title>
    
	<script type="text/javascript">
		 $(document).ready( function () {
			 $("body").css('visibility','visible');
		 });
	</script>
  </head>
  <body>
	  <div id="pageStatFrame">
			<?php echo $sf_content ?>
	  </div>
  </body>
  
</html>