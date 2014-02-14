<?php slot('title', sprintf('GENEPI - '.__('Structure')))?>

<?php include 'secondaryMenu.php'?>

<?php include_partial('global/messages')?>

<head>
  <script type="text/javascript">
	  $(document).ready(function() {
	    $("#tabs").tabs();

	    $("#buildingsTable,#roomsTable,#computersTable,#financiersTable").dataTable({
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
        <li><a href="#structure"><span><?php echo __('Structure')?></span></a></li>
        <li><a href="#buildings"><span><?php echo __('Buildings')?></span></a></li>
        <li><a href="#rooms"><span><?php echo __('Rooms')?></span></a></li>
        <li><a href="#computers"><span><?php echo __('Computers')?></span></a></li>
        <li><a href="#financiers"><span><?php echo __('Financiers')?></span></a></li>
    </ul>
    <div id="structure">
		<table class="twoColumnsTableForm">
			  <tbody>
			 	 <tr>
			        <th><?php echo __('Logo') ?></th>
			        <td>
			          <div class="restrict-picture-size">
			         	<?php echo image_tag('/uploads/images/logo.png?'.microtime(), array('height' => '90', 'alt' => __('No Logo'))) ?>
			          </div>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Structure name') ?></th>
			        <td>
			         <?php echo $structure->getName();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('E-mail'); ?></th>
			        <td>
			         <?php echo $structure->getEmail();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Website'); ?></th>
			        <td>
			         <?php echo $structure->getWebsite();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Telephone number'); ?></th>
			        <td>
			         <?php echo $structure->getTelephoneNumber();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Telephone number n°2'); ?></th>
			        <td>
			         <?php echo $structure->getAddress()->getTelephoneNumber();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Street'); ?></th>
			        <td>
			         <?php echo $structure->getAddress()->getStreet();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Postal code'); ?></th>
			        <td>
			         <?php echo $structure->getAddress()->getAddressCity()->getPostalCode();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('City'); ?></th>
			        <td>
			         <?php echo $structure->getAddress()->getAddressCity()->getName();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('Country'); ?></th>
			        <td>
			         <?php echo $structure->getAddress()->getAddressCity()->getAddressCountry();?>
			        </td>
			      </tr>
			      <tr>
			        <th><?php echo __('SIRET/INSEE number'); ?></th>
			        <td>
			         <?php echo $structure->getSiretNumber();?>
			        </td>
			      </tr>
			  </tbody>
			</table>
		<div class="rightAlignement">
			<input type="button" value=<?php echo __('Edit')?> onClick="document.location.href='<?php echo url_for('struct/editStructure?id='.$structure->getId()) ?>';">
		</div>
	</div>
    <div id="buildings">
    	<h1><?php echo __('Buildings List')?></h1>
    	<table class="threeColumnsTable" id="buildingsTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Building name')?></th>
		      <th style="width: 200px"><?php echo __('Shortened Name')?></th>
		      <th style="width: 200px"><?php echo __('Number of associated rooms')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($buildings as $building): ?>
			    <?php if($building->getId() == $defaultBuilding):?>
				    <tr class="bold">
				      <td><a href="<?php echo url_for('struct/editBuilding?id='.$building->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $building->getDesignation() ?></a></td>
				      <td><?php echo $building->getShortenedDesignation() ?></td>
				      <td><?php echo $building['number_rooms'] ?></td>
				    </tr>
				<?php else:?>
					<tr>
				      <td><a href="<?php echo url_for('struct/editBuilding?id='.$building->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $building->getDesignation() ?></a></td>
				      <td><?php echo $building->getShortenedDesignation() ?></td>
				      <td><?php echo $building['number_rooms'] ?></td>
				    </tr>
				<?php endif;?>
		    <?php endforeach; ?>
		  </tbody>
		  
		</table>
		<div class="rightAlignement">
			<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('struct/newBuilding')?>';">
	    </div>
    </div>
    <div id="rooms">
    	<h1><?php echo __('Rooms List')?></h1>
    	<table class="largeTable" id="roomsTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Room name')?></th>
		      <th style="width: 200px"><?php echo __('Shortened Name')?></th>
		      <th style="width: 200px"><?php echo __('Number of computers')?></th>
		      <th><?php echo __('Building')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($rooms as $room): ?>
			    <?php if($room->getId() == $defaultRoom):?>
				    <tr class="bold">
				      <td><a href="<?php echo url_for('struct/editRoom?id='.$room->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $room->getDesignation() ?></a></td>
				      <td><?php echo $room->getShortenedDesignation() ?></td>
				      <td><?php echo $room['number_computers'] ?></td>
				      <td><?php echo $room->getBuilding() ?></td>
				    </tr>
			    <?php else:?>
			    	<tr>
				      <td><a href="<?php echo url_for('struct/editRoom?id='.$room->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $room->getDesignation() ?></a></td>
				      <td><?php echo $room->getShortenedDesignation() ?></td>
				      <td><?php echo $room['number_computers'] ?></td>
				      <td><?php echo $room->getBuilding() ?></td>
				    </tr>
			    <?php endif;?>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('struct/newRoom')?>';">
	    </div>
    </div>
    <div id="computers">
    <h1><?php echo __('Computers List')?></h1>
    	<table class="largeTable" id="computersTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Computer name')?></th>
		      <th style="width: 200px"><?php echo __('Shortened Name')?></th>
		      <th style="width: 150px"><?php echo __('Machine Type')?></th>
		      <th><?php echo __('Operating System')?></th>
		      <th><?php echo __('Room')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($computers as $computer): ?>
		    	<?php if($computer->getId() == $defaultComputer):?>
				    <tr class="bold">
				      <td><a href="<?php echo url_for('struct/editComputer?id='.$computer->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $computer->getName() ?></a></td>
				      <td><?php echo $computer->getShortenedName() ?></td>
				      <td><?php echo $computer->getComputerMachineType() ?></td>
				      <td><?php echo $computer['os_family']." ".$computer->getComputerOs() ?></td>
				      <td><?php echo $computer->getRoom() ?></td>
				    </tr>
				<?php else:?>
			    	<tr>
				      <td><a href="<?php echo url_for('struct/editComputer?id='.$computer->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $computer->getName() ?></a></td>
				      <td><?php echo $computer->getShortenedName() ?></td>
				      <td><?php echo $computer->getComputerMachineType() ?></td>
				      <td><?php echo $computer['os_family']." ".$computer->getComputerOs() ?></td>
				      <td><?php echo $computer->getRoom() ?></td>
				    </tr>
			    <?php endif;?>
		    <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('struct/newComputer')?>';">
	    </div>
    </div>
    <div id="financiers">
    	<h1><?php echo __('Financiers List')?></h1>
    	<table class="threeColumnsTable" id="financiersTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Financier name')?></th>
		      <th><?php echo __('Logo')?></th>
		      <th><?php echo __('Comment')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($financiers as $financier): ?>
		    <tr>
		      <td><a href="<?php echo url_for('struct/editFinancier?id='.$financier->getId()) ?>" title="<?php echo __('Click to modify') ?>" ><?php echo $financier->getName() ?></a></td>
		      <td>
		      		<?php echo image_tag('/uploads/images/'.$financier->getLogoPath().'?'.microtime(), array('height' => '90')) ?>
		      </td>
		      <td><?php echo $financier->getComment() ?></td>
		    </tr>
		    <?php endforeach; ?>
		  </tbody>
		</table>
	    <div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('struct/newFinancier')?>';">
	    </div>
    </div>
</div>