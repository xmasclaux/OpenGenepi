<?php slot('title', sprintf('GENEPI - '.__('History')))?>

<?php include_partial('global/messages')?>

<head>
  <script type="text/javascript">

	  var historyTab;
	    
	  $(document).ready(function() {

	    $("#historyTab_filter").live('keydown, keyup', function() {
			$('table tbody tr td[class="dataTables_empty"]').attr('colspan',6);
		});
		  
		historyTab = $("#historyTab").dataTable({
			"aoColumns": [ 
      			{ "bSortable": false },
      			{ "bSortable": false },
      			null,
      			null,
      			null,
      			null,
      			{ "bVisible": false }
    		],  
    		"fnInitComplete": function(){
				$('table tbody tr td[class="dataTables_empty"]').attr('colspan',6);
			},		
			"sPaginationType": "full_numbers",
			"bAutoWidth": false,
	      	"iDisplayLength": <?php echo $defaultLength ?>,
	      	"oLanguage": {
	      		"sUrl": "<?php echo sfContext::getInstance()->getUser()->getAttribute('relativeUrlRoot'); ?>" + "/lang/" + "<?php echo $userCulture ?>"
	    		},
	    	"aaSorting": []     	
		} );

		$("#imputationDeletion").click(function(){removeImputation();});

		$('#historyTab tr').each(function(e, f){
		          $(f).mouseover(
		               function() { $('#historyTab tr:nth-child(' + e + ')').addClass("highlight"); },
		               function() { $('#historyTab tr:nth-child(' + e + ')').removeClass("highlight"); }
		          );
		          $(f).mouseout(
			           function() { $('#historyTab tr:nth-child(' + e + ')').removeClass("highlight"); }
			      );
		});

		$('#historyTab tbody tr td:not(:has(input[type="checkbox"]))').live('click', function () {
			
			var rowNumber = historyTab.fnGetPosition(this);
			var data = historyTab.fnGetData( rowNumber[0] );
			var imputationId = data[6];

			$("#dialogImputationInfo").load('<?php echo url_for('use/AjaxImputationInfo') ?>', { id: imputationId },
					function(data) {
				  	  $( "#dialogImputationInfo" ).dialog( { 
						width: 750,
						close: true,
						resizable: false,
						modal: true,
						draggable: false,
						buttons: { 
							"Ok": function() { $(this).dialog("close"); }}
					} );
				},"json")
		});
		
	  });

	  function removeImputation(){
		  var imputationId = new Array();
		  $("#historyTab tbody tr:has(input[type=checkbox]:checked)").each(function(){
			  var rowNumber = historyTab.fnGetPosition( this );
			  var data = historyTab.fnGetData( rowNumber );
			  imputationId.push(data[6]);
		  })

		  $("#dialogImputationDelete").load('<?php echo url_for('use/AjaxDeleteImputation') ?>', { id: imputationId },
			function(data) {
		  	  $( "#dialogImputationDelete" ).dialog( { 
				width: 750,
				close: true,
				resizable: false,
				modal: true,
				draggable: false,
			} );
		},"json")
		  
	  }
	  
  </script>
</head>

<?php slot('secondaryMenu') ?>
	<h2><?php echo __('Functionalities')?></h2>
	<h3><a href="<?php echo url_for('use/index') ?>"><?php echo __('Impute an act')?></a></h3>
	<h3 class = "selected"><?php echo __('View history')?></h3>
<?php end_slot(); ?>

<h1><?php echo __('Uses history')?></h1>
<div class="info-message-white">
	<span class="info-message-icon"></span>
	<em><?php echo __('This menu allows you to delete imputations of all types. Fot the multiple services, the deletion of the imputation will not delete the created account. Use the Users/Manage the accounts menu to do so.')?></em>
</div>
<br /><br /><br /><br />

<div id="dialogImputationDelete" title="<?php echo __("Uses deletion")?>" style="display:none"></div>
<div id="dialogImputationInfo" title="<?php echo __("Use info")?>" style="display:none"></div>

<table id="historyTab" class="largeTable">
  <thead>
    <tr class="sortableTable">
      <th class="greyCell" style="width:30px"></th>
      <th class="greyCell" style="width:130px"><?php echo __('Date')?></th>
      <th style="width:120px"><?php echo __('Moderator')?></th>
      <th><?php echo __('Act name')?></th>
      <th><?php echo __('User')?></th>
      <th style="width:60px"><?php echo __('Price')?></th>
      <th>imputationId</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($imputations as $imputation): ?>
    <tr>
      <td align=center id="checkbox"><input type="checkbox"></input></td>
      <td><?php echo date_format(new DateTime($imputation->getDate()), __('m-d-Y').' H:i') ?></td>
     
      <td>
	      <?php if($imputation->getModeratorId() != null):?>
	      	<?php echo $imputation->getModerator()->getLogin()?>
	      <?php else:?>
	        <?php echo " "?>
		  <?php endif;?>
      </td>
      
      <td>
	      <?php if($imputation->getImputationType() != "1"):?>
		    <?php echo $imputation->getAct()?>
		  <?php else:?>
		  	<?php echo __('Account Transaction')?>
		  <?php endif;?>
	  </td>
	  
	  <td>
		  <?php if($imputation->getUserId() != null):?>
		    <?php echo $imputation->getUser()?>
		  <?php else:?>
		  	<?php echo __('Anonymized')?>
		  <?php endif;?>
	  </td>
	  
	  <td>
		  <?php if ($imputation->getTotal() != null):?>
		  	<?php echo $imputation->getTotal()." ".$defaultCurrency ?>
		  <?php else :?>
		    <?php echo ""?>
		  <?php endif;?>
	  </td>
	  
	  <td><?php echo $imputation->getId()?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="rightAlignement">
	<input type="button" id="imputationDeletion" value="<?php echo __('Delete')."..."?>">
</div>