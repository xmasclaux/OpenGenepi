<?php slot('title', sprintf('GENEPI - '.__('Export')))?>

<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3><a href="<?php echo url_for('act/index') ?>"><?php echo __('Manage acts')?></a></h3>
    <h3><a href="<?php /* KYXAR 0007 - 01/07/2011 */ echo url_for('configuration/parameters#lists') ?>"><?php echo __('Manage public categories')?></a></h3>
	<h3><a href="<?php echo url_for('act_price/index') ?>"><?php echo __('Manage prices')?></a></h3>
	<h3><a href="<?php echo url_for('moderator/index') ?>"><?php echo __('Manage moderators')?></a></h3>
	<h3><a href="<?php echo url_for('struct/index') ?>"><?php echo __('Manage structure')?></a></h3>
	<h3><a href="<?php echo url_for('configuration/parameters') ?>"><?php echo __('Manage parameters')?></a></h3>
	<h3><a href="<?php echo url_for('configuration/plugins') ?>"><?php echo __('Manage plugins')?></a></h3>
	<h3 class ="selected"><?php echo __('Export logs')?></h3>
	<h3><a href="<?php echo url_for('dashboard/index') ?>"><?php echo __('Back to homepage')?></a></h3>
<?php end_slot(); ?>

<link href="<?php echo url_for("/css/export.css")?>" rel="stylesheet" type="text/css">

<script type="text/javascript">
	$(document).ready(function() {
	 	document.getElementById("javascript-support").innerHTML = "<?php echo __('enabled')?>";
	});

	function showphpinfo() {
		$('#phpinfo').show();
	}

	function hidephpinfo() {
		$('#phpinfo').hide();
	}
</script>

<h1><?php echo __('Log export'). ' - '.date('d/m/y G:i:s') ?></h1>

<div class="panel">
	<h6><?php echo __('Server')?></h6>
	<?php echo __('Signature').' : '.getenv("SERVER_SOFTWARE"); ?>
</div>

<div class="panel">
	<h6><?php echo __('Database')?></h6>
	<?php echo __('DBMS').' :'?>
	<?php if($dbvalues['dbms'] == 1) : ?> <?php echo 'MySQL'?>
	<?php else : ?> <?php echo 'PostgreSQL'?>
	<?php endif; ?>
</div>

<div class="panel">
	<h6><?php echo __('Client')?></h6>
	<?php echo __('Browser').' : '.getenv("HTTP_USER_AGENT"); ?>
	<br/>
	<?php $screenWidth = "<script>document.write(screen.width)</script>"; ?>
	<?php $screenHeight = "<script>document.write(screen.height)</script>"; ?>
	<?php echo __('Screen resolution').' : '.$screenWidth.'x'.$screenHeight; ?>
</div>

<div class="panel">
	<h6><?php echo __('JavaScript')?></h6>
	<?php echo __('JavaScript support').' : '?>
	<div id="javascript-support" style="display: inline;">
		<?php echo __('disabled')?>
	</div>
</div>

<div class="panel">
	<h6><?php echo __('Plugins')?></h6>
	<table>
			<thead>
				<tr>
					<th><?php echo __('Module Name')?></th>
					<th><?php echo __('Dependencies')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($Kernel->getDependenciesTable() as $module => $dependencies):?>
				<?php $display_alert = false;?>
				<tr>
					<td style="width: 200px;" align=center><strong><?php echo($module)?></strong></td>
					<td>
						<table style="border: none;">
						<?php foreach ($dependencies as $dependency):?>
							<tr>
								<th style="width: 150px;"><label><?php echo($dependency)?></label></th>
								<td>
			            			<?php if( Module::isActivated($Modules, $dependency)):?>
					            			<?php echo __('Dependency satisfied')?>
				            		<?php else:?>
											<?php $display_alert = true;?>
					            			<?php echo __('Dependency not satisfied')?>
				            		<?php endif;?>
				        		</td>
							</tr>
						<?php endforeach;?>
						</table>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<br />
		<table style="border-style: solid;">
			<thead>
				<tr>
					<th><?php echo __('Module Name')?></th>
					<th><?php echo __('Is Compulsory')?></th>
					<th><?php echo __('Menu Entry Name')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($Modules as $module):?>
				<tr>
					<td><?php echo ($module->getModuleName())?></td>
					<td><?php if($module->isCompulsory()){
								echo __('yes');
							  }else{
								echo __('no');
					}?></td>
					<td><?php echo __($module->getMenuEntryName())?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

<input type="button" value="<?php echo __('More').'...' ?>" onclick=showphpinfo()></input>

<div class="rightAlignement">
	<input type="button" value=<?php echo __('Export to a text format')?> onClick="document.location.href='<?php echo url_for('configuration/textExport')?>';">
</div>
</div>


<div id="phpinfo" style ="display:none;" >
	<div class="panel">
	      <?php
		      ob_start();
		      phpinfo();
		      $pinfo = ob_get_contents();
		      ob_end_clean();
		      $pinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$pinfo);
		      echo $pinfo;
	      ?>
	      <input type="button" value="<?php echo __('Hide') ?>" onclick=hidephpinfo()></input>
	</div>
</div>