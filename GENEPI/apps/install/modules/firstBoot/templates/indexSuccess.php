<?php slot('title', sprintf('GENEPI - '.__('Configuration')))?>

<h1><?php echo __('GENEPI configuration')?></h1>

<br />
<center>
	<?php echo image_tag('/uploads/images/logo.png?'.microtime(), array()) ?>
</center>
<br />

<center>
	<h3><?php echo __('Choose your language')." : "?></h3>
</center>

<form method="post" action="<?php echo url_for('firstBoot/introduction')?>">
	<center>
		<select name="culture">
			<?php foreach($cultures as $shortened_culture => $culture):?>
				<option value="<?php echo $shortened_culture?>"><?php echo $culture?></option>
			<?php endforeach;?>
		</select>
	</center>
	
	<br /><br />

	<center>
		<input type="submit" value="<?php echo __("Continue")?>"></input>
	</center>
</form>