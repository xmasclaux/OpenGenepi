<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3 class="selected" ><?php echo __('Manage acts')?></h3>
    <h3><a href="<?php /* KYXAR 0007 - 01/07/2011 */ echo url_for('configuration/parameters#lists') ?>"><?php echo __('Manage public categories')?></a></h3>
	<h3><a href="<?php echo url_for('act_price/index') ?>"><?php echo __('Manage prices')?></a></h3>
	<h3><a href="<?php echo url_for('moderator/index') ?>"><?php echo __('Manage moderators')?></a></h3>
	<h3><a href="<?php echo url_for('struct/index') ?>"><?php echo __('Manage structure')?></a></h3>
	<h3><a href="<?php echo url_for('configuration/parameters') ?>"><?php echo __('Manage parameters')?></a></h3>
	<h3><a href="<?php echo url_for('configuration/plugins') ?>"><?php echo __('Manage plugins')?></a></h3>
	<h3><a href="<?php echo url_for('configuration/export') ?>"><?php echo __('Export logs')?></a></h3>
	<h3><a href="<?php echo url_for('dashboard/index') ?>"><?php echo __('Back to homepage')?></a></h3>
<?php end_slot(); ?>