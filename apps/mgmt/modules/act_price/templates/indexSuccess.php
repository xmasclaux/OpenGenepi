<?php include 'secondaryMenu.php'?>

<?php slot('title', sprintf('GENEPI - '.__('Prices')))?>

<?php include_partial('global/messages')?>

<h1><?php echo __('Prices management')?></h1>

<script type="text/javascript">
	function help(){
		$( "#dialog" ).dialog( { 
			width: 700,
			close: false,
			resizable: false,
			modal: true,
			draggable : false,
			buttons: {
                <?php echo __('Ok') ?>: function() {
                        $(this).dialog("close");
                }	
        	}
		} );
	}

	var table = new Array();

	//When the user submits the form, we fill a hidden field called modifiedCells
	//It is posted with the other values of the form
	function setValue(){
		document.getElementById('modifiedCells').value = table;
	}
	
$(document).ready(function() {
	//We save in a table all the cells that have been updated
	$("td input").focus(function(){
		table.push(this.name);
	});

	$('table').each(function() {
        $('tr:even', this).addClass('even');
        $('tr:even td input', this).css("background","#f2f2f2");
	});

	$("tr:even td input").hover(function () {
	    $(this).css({'background' : '#d3d3d3'});
	  }, function () {
		  $(this).css({'background' : '#f2f2f2'});
	  });
});

</script>




<div id="dialog" title="<?php echo __("Help")?>" style="display:none">
	<p><?php echo __('Click on a cell to insert a new price.')?></p>
	<p><?php echo __('A blank cell indicates that no price is fixed yet for this act and this public category.')?></p>
	<p><?php echo __('"0" indicates that the act is free for the public category.')?></p>
	<p><?php echo __('All the prices are in ').$defaultCurrency."."?></p>
	<br />
	<p><?php echo __('Once you have finished, click on "Confirm".') ?></p>
</div>

<form action="<?php echo url_for('act_price/updateActPrices') ?>" method="post" onSubmit=setValue()>
	<table class="largeTable">
	  <thead>
	    <tr>
	      <th class="greyCell"><?php echo __('Act') ?></th>
	      <?php foreach ($publicCategories as $publicCategory):?>
		      <th><?php echo $publicCategory->getDesignation() ?></th>
		  <?php endforeach;?>
	    </tr>
	  </thead>
	  <tbody>
	    <?php foreach ($acts as $act): ?>
		    <tr style="text-align:center;">
		      <td><?php echo $act->getShortenedDesignation();?></td>
		      <?php foreach ($publicCategories as $publicCategory): ?>
			      <td class="actPrice">
			      <?php if (isset($errorArray[$act->getId()])): ?>
				      <?php if (isset($errorArray[$act->getId()][$publicCategory->getId()])):?>
						<input type="text" size="auto"
			      		   style="text-align:center; border: none; color: #b00000; font-weight:bold;" 
			      		   name="<?php echo 'price_'.$act->getId().'_'.$publicCategory->getId()?>" 
			      			   <?php if ($errorArray[$act->getId()][$publicCategory->getId()] != -1): ?>
				      		   		value="<?php echo $errorArray[$act->getId()][$publicCategory->getId()]?>"
				      		   <?php else :?>
				      		   		value=" "
				      		   <?php endif;?>
			      		></input>
					  <?php else :?>
					  	<input type="text" size="auto" 
			      		   style="text-align:left; border: none;" 
			      		   name="<?php echo 'price_'.$act->getId().'_'.$publicCategory->getId()?>" 
			      			   <?php if ($price[$act->getId()][$publicCategory->getId()] != -1): ?>
				      		   		value="<?php echo $price[$act->getId()][$publicCategory->getId()]?>"
				      		   <?php else :?>
				      		   		value=" "
				      		   <?php endif;?>
			      		></input>
					  <?php endif;?>
			      <?php else :?>
			      	<input type="text" size="auto"
			      		   style="text-align:left; border: none;" 
			      		   name="<?php echo 'price_'.$act->getId().'_'.$publicCategory->getId()?>" 
			      			   <?php if ($price[$act->getId()][$publicCategory->getId()] != -1): ?>
				      		   		value="<?php echo $price[$act->getId()][$publicCategory->getId()]?>"
				      		   <?php else :?>
				      		   		value=" "
				      		   <?php endif;?>
			      	></input>
			      </td>
			      <?php endif;?>
			  <?php endforeach;?>
		    </tr>
	    <?php endforeach; ?>
	  </tbody>
	</table>
	
	<input type=hidden id=modifiedCells name=modifiedCells ></input>
	
	<span class="deletion-button" onclick="help();">
          <input type="button" value="<?php echo __('Help')."..."?>"></input>
    </span>
	<div class="rightAlignement">
	    <input type="submit" value=<?php echo __('Confirm')?>></input>
	</div>
</form>