<?php slot('title', sprintf('GENEPI - '.__('Dashboard')))?>

<?php
    define('USERS_AUTH_CLASS',dirname(__FILE__).'/../../auth/lib/usersAuth.class.php');
	require_once(USERS_AUTH_CLASS);
?>

<?php slot('secondaryMenu') ?>
<h2><?php echo __('Homepage')?></h2>
<?php
	$usersAuth = new usersAuth();
	$modules = sfContext::getInstance()->get('Modules');
	$end_if = 1;
	foreach ($modules as $module)
	{
		/*Compare User Credentials to Action Credentials*/
		/*According to the case, the secondary menu is different*/
		if(!is_null($module->getMenuEntryName())){
			$context = sfContext::getInstance();
			$action = $context->getController()->getAction($module->getModuleName(), 'index');
			$credential = $action->getCredential();
			$haveCredentials = $this->context->getUser()->hasCredential($credential);
		}
		else
		{
			$haveCredentials=false;
		}

	  	if($haveCredentials){
	  		if ($end_if && !strcasecmp($module->getModuleName(),sfContext::getInstance()->getModuleName()))
	  		{
	  			echo "<h3 class=\"selected\">".__($module->getMenuEntryName())."</h3>";
	  			$end_if = 0;
	  		}
	  		else
	  		{
				echo "<h3><a href=\"".url_for($module->getModuleName().'/index')."\">".__($module->getMenuEntryName())."</a></h3>";
	  		}
	  	}
      }
?>

<?php end_slot(); ?>


<?php include_partial('global/messages')?>

<h1><?php echo __('Dashboard of the current month')?></h1>

<?php echo __('From the ').date_format(new DateTime($beginningDate), __('m-d-Y'))." ".__('to the ').date_format(new DateTime($endDate), __('m-d-Y')) ?>

<div class="panel">
	<h6><?php echo __('Global data')?></h6>
	<ul>
		<li>
			<?php echo __('Total of uses')." : ".$numberOfVisits?>
		</li>
		<li>
			<?php echo __('Unique visitors')." : ".$numberOfUniqueVisitors?>
		</li>
		<li>
			<?php echo __('Regular visitors')." : ".$numberOfRegularVisitors?>
		</li>
	</ul>
</div>

<div class="panel">
	<h6><?php echo __('Checkout')?></h6>
	<ul>
		<li>
			<?php echo __('Total')." : ".$checkoutTotal." ".$defaultCurrency?>
		</li>
	</ul>
</div>

<div class="panel">
	<h6><?php echo __('Subscriptions')?></h6>
	<ul>
		<li>
			<?php echo __('Number of valid subscriptions today')." : ".$numberOfValidSubscriptionsBeginning ?>
		</li>
		<li>
			<?php echo __('Number of valid subscriptions at the end of the month')." : ".$numberOfValidSubscriptionsEnd?>
		</li>
	</ul>
</div>

<div class="panel">
	<h6><?php echo __('Users')?></h6>
	<table class="threeColumsStat">
	  <thead>
	 	 <tr>
	        <th><?php echo __('Public category') ?></th>
	        <th><?php echo __('Total of uses (with a duration or not)') ?></th>
	        <th><?php echo __('Time') ?></th>
	      </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($publicCategories as $publicCategory):?>
	 	 <tr>
	        <td class="important"><?php echo $publicCategory->getDesignation() ?></td>
	        <td class="centered">
	      		<?php if ($numberOfUsesPerCategory[$publicCategory->getId()] != "0"): ?>
	        		<?php echo $numberOfUsesPerCategory[$publicCategory->getId()] ?>
	        	<?php else :?>
	        		<?php echo " " ?>
	        	<?php endif;?>
	        </td>
	        <td class="centered">
	        	<?php if ($timePerCategory[$publicCategory->getId()] != "0"): ?>
	        		<?php echo $timePerCategory[$publicCategory->getId()]." ".__('hour(s)') ?>
	        	<?php else :?>
	        		<?php echo " " ?>
	        	<?php endif;?>
	        </td>
	      </tr>
	  <?php endforeach;?>
	  	<tr>
	        <td class="important"><?php echo __('No category') ?></td>
	        <td class="centered">
	        	<?php if($numberOfUsesPerCategory[0] != 0): ?>
	        		<?php echo $numberOfUsesPerCategory[0] ?>
	        	<?php else :?>
	        		<?php echo " " ?>
	        	<?php endif;?>
	        </td>
	        <td class="centered">
	        	<?php if ($timePerCategory[0] != "0"): ?>
	        		<?php echo $timePerCategory[0]." ".__('hour(s)') ?>
	        	<?php else :?>
	        		<?php echo " " ?>
	        	<?php endif;?>
	        </td>
	      </tr>
	  </tbody>
	  <tfoot>
	  	<tr>
	        <th><?php echo __('Total')?></th>
	        <th>
	        	<?php if($numberOfUses != 0): ?>
	        		<?php echo $numberOfUses ?>
	        	<?php else :?>
	        		<?php echo " " ?>
	        	<?php endif;?>
	        </th>
	        <th>
	        	<?php echo $totalDuration." ".__('hour(s)')?>
	        </th>
	      </tr>
	  </tfoot>
	</table>
</div>