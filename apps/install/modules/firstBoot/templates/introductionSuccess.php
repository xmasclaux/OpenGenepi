<?php slot('title', sprintf('GENEPI - '.__('Configuration')))?>

<h1><?php echo __('GENEPI configuration')?></h1>

<br />
<center>
	<?php echo image_tag('/uploads/images/logo.png?'.microtime(), array()) ?>
</center>
<br />

<center>
	<h3><?php echo __("Welcome in the configuration procedure of GENEPI.")?></h3>
	<br />
	<h3><?php echo __("In order to proceed to the software configuration, you will need to know:")?></h3>
		. <?php echo __('the IP address or the name and the port of your database server (MySQL or PostgreSQL)')?>
		<br /><br />
		. <?php echo __('a login and a password that will be used by GENEPI to connect to the database server')."."?>
</center>

<br /><br />
<center>
	<h3><?php echo __("As long as the configuration is not achieved, these pages will remain available")."."?></h3>
	<h3><?php echo __('Once the configuration achieved and all the tests checked, the homepage will appear automatically and the configuration pages will not be reachable anymore').'.'?></h3>
</center>

<form method="post" action="<?php echo url_for('firstBoot/stepOne')?>">
	<center>
		<input type="submit" value="<?php echo __("Continue")?>"></input>
	</center>
</form>