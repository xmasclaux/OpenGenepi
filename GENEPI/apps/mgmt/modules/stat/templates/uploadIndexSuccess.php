<?php slot('title', sprintf('GENEPI - '.__('Statistics')))?>

<?php include_partial('global/messages')?>

<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3><a href="<?php echo url_for('stat/index')?>"><?php echo __('Detailed statistics')?></a></h3>
	<h3><a href="<?php echo url_for('stat/quantitativeStatementIndex')?>"><?php echo __('Quantitative statement')?></a></h3>
	<h3><a href="<?php echo url_for('stat/temporalStatementIndex')?>"><?php echo __('Temporal statement')?></a></h3>
	<h3><a href="<?php echo url_for('stat/balanceIndex')?>"><?php echo __('Balance')?></a></h3>
	<h3><a href="<?php echo url_for('stat/exportIndex') ?>"><?php echo __('Export')?></a></h3>
	<h3 class = "selected"><?php echo __('Upload/Download')?></h3>
<?php end_slot(); ?>

<h1><?php echo __('Upload or download statistics')?></h1>
<div class="info-message-white">
	<span class="info-message-icon"></span>
	<em><?php echo __('This menu allows you to upload the statistics of your structure. They will used by your overall structure.')?></em>
</div>

<br /><br />


	<div class="panel">
		<b><?php echo __('Last upload:')?></b>
		
		<input type="text" value="<?php echo date(__('m-d-Y'), strtotime($last_upload));?>" readonly="readonly">
		<br />
		<div class="rightAlignement">
			<form action="<?php echo url_for('stat/upload')?>" method="post" style="display:inline">
				<input type="submit" value="<?php echo __('Upload on the server')?>">
			</form>
			<form action="<?php echo url_for('stat/download')?>" method="post" style="display:inline">
				<input type="submit" value="<?php echo __('Download on your computer')?>">
			</form>
		</div>
	</div>
