<?php include 'secondaryMenu.php'?>

<?php slot('title', sprintf('GENEPI - '.__('Acts')))?>

<?php include_partial('global/messages')?>

<head>
  <script type="text/javascript">
	  $(document).ready(function() {
	    $("#tabs").tabs();
		  
		$("#actsTable,#subscriptionsTable,#purchasesTable,#unitaryServicesTable,#multipleServicesTable").dataTable({
			"sPaginationType": "full_numbers",
			"bAutoWidth": false,
	      	"iDisplayLength": <?php echo $defaultLength ?>,
	      	"oLanguage": {
	      		"sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>"
	    		},
	    	"aaSorting": []
		} );
	  });
  </script>
</head>

<div id="tabs">
    <ul>
        <li><a href="#all"><span><?php echo __('All')?></span></a></li>
        <li><a href="#subscriptions"><span><?php echo __('Subscriptions')?></span></a></li>
        <li><a href="#purchases"><span><?php echo __('Purchases')?></span></a></li>
        <li><a href="#unitary-services"><span><?php echo __('Unitary services')?></span></a></li>
        <li><a href="#multiple-services"><span><?php echo __('Multiple services')?></span></a></li>
    </ul>
    <div id="all">
    	<h1><?php echo __('List of predefined acts')?></h1>
    	<table class="threeColumnsTable" id="actsTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Act name')?></th>
		      <th style="width: 250px"><?php echo __('Shortened Name')?></th>
		      <th style="width: 180px"><?php echo __('Act type')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($acts as $act): ?>
		    <tr>
		      <td>
	      		<?php 
	      		$actType = $act->getActTypeId();
	      		if($actType == 1) { 
	      			echo "<a href=".url_for('act/editSubscription?id='.$act->getId().'&index=1')." title=\"";?><?php echo __("Click to modify")."\">" ?><?php 
	      		}
	      		else if($actType == 2){
	      			echo "<a href=".url_for('act/editUnitaryService?id='.$act->getId().'&index=1')." title=\"";?><?php echo __("Click to modify")."\">" ?><?php 
	      		}
	      		else if($actType == 3){
	      			echo "<a href=".url_for('act/editMultipleService?id='.$act->getId().'&index=1')." title=\"";?><?php echo __("Click to modify")."\">" ?><?php 
	      		}
	      		else{
	      			echo "<a href=".url_for('act/editPurchase?id='.$act->getId().'&index=1')." title=\"";?><?php echo __("Click to modify")."\">" ?><?php 
	      		}
	      		?>
	      		
	    		<?php echo $act->getDesignation()."</a>" ?>
		      </td>
		      <td><?php echo $act->getShortenedDesignation() ?></td>
		      <td><?php echo $act->getActType() ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		  <tfoot></tfoot>
		</table>
    </div>
    <div id="subscriptions">
    	<h1><?php echo __('List of predefined subscriptions')?></h1>
    	<table class="twoColumnsTable" id="subscriptionsTable">
		  <thead>
		    <tr class="sortableTable">
		      <th style="width: 100%"><?php echo __('Subscription name')?></th>
		      <th style="width: 250px"><?php echo __('Shortened Name')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($subscriptions as $subscription): ?>
		    <tr>
		      <td><a href="<?php echo url_for('act/editSubscription?id='.$subscription->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $subscription->getDesignation() ?></a></td>
		      <td><?php echo $subscription->getShortenedDesignation() ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="rightAlignement">
			<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('act/newSubscription')?>';">
	    </div>
    </div>
    <div id="purchases">
    	<h1><?php echo __('List of predefined purchases')?></h1>
    	<table class="twoColumnsTable" id="purchasesTable">
		  <thead>
		    <tr class="sortableTable">
		      <th style="width: 100%"><?php echo __('Purchase name')?></th>
		      <th style="width: 250px"><?php echo __('Shortened Name')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($purchases as $purchase): ?>
		    <tr>
		      <td><a href="<?php echo url_for('act/editPurchase?id='.$purchase->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $purchase->getDesignation() ?></a></td>
		      <td><?php echo $purchase->getShortenedDesignation() ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('act/newPurchase')?>';">
	    </div>
    </div>
    <div id="unitary-services">
    	<h1><?php echo __('List of predefined unitary services')?></h1>
    	<table class="twoColumnsTable" id="unitaryServicesTable">
		  <thead>
		    <tr class="sortableTable">
		      <th style="width: 100%"><?php echo __('Unitary service name')?></th>
		      <th style="width: 250px"><?php echo __('Shortened Name')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($unitaryServices as $unitaryService): ?>
		    <tr>
		      <td><a href="<?php echo url_for('act/editUnitaryService?id='.$unitaryService->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $unitaryService->getDesignation() ?></a></td>
		      <td><?php echo $unitaryService->getShortenedDesignation() ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('act/newUnitaryService')?>';">
	    </div>
    </div>
    <div id="multiple-services">
    	<h1><?php echo __('List of predefined multiple services')?></h1>
    	<table class="threeColumnsTable" id="multipleServicesTable">
		  <thead>
		    <tr class="sortableTable">
		      <th style="width: 100%"><?php echo __('Multiple service name')?></th>
		      <th style="width: 250px"><?php echo __('Shortened Name')?></th>
		      <th style="width: 150px"><?php echo __('Quantity')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($multipleServices as $multipleService): ?>
		    <tr>
		      <td><a href="<?php echo url_for('act/editMultipleService?id='.$multipleService->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $multipleService->getDesignation() ?></a></td>
		      <td><?php echo $multipleService->getShortenedDesignation() ?></td>
		      <td><?php echo $multipleService->getQuantity()." ".$multipleService->getUnity() ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('act/newMultipleService')?>';">
	    </div>
    </div>
</div>