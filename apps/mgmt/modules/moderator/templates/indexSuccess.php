<?php slot('title', sprintf('GENEPI - '.__('Moderators')))?>

<?php include_partial('global/messages')?>

<?php include('secondaryMenu.php')?>

<head>
  <script type="text/javascript">
	  $(document).ready(function() {
	    $("#tabs").tabs();

	    $("#animators_table,#viewers_table").dataTable({
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
        <li><a href="#animators"><span><?php echo __('Administrators')?></span></a></li>
        <li><a href="#viewers"><span><?php echo __('Viewers')?></span></a></li>
    </ul>
	
	<div id="animators">
		<h1><?php echo __('Administrators List')?></h1>
		<table id="animators_table" class="largeTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
		      <th><?php echo __('E-mail')?></th>
		      <th style="width: 150px"><?php echo __('Login')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($moderators as $moderator): ?>
			    <?php if($moderator->getLogin()->getIsModerator()):?>
				    <tr>
					    <td>
					      	<a href="<?php echo url_for('moderator/edit?id='.$moderator->getId()) ?>">
					      		<?php echo $moderator->getName() ?> <?php echo $moderator->getSurname() ?> 
					      	</a>
					    </td>
					    <td><?php echo $moderator->getEmail() ?></td>
					    <td><?php echo $moderator->getLogin()->getLogin() ?></td>
				    </tr>
			    <?php endif;?>
		    <?php endforeach; ?>
		  </tbody>
		</table>
	  	<div class="rightAlignement">
	  		<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('moderator/new?type=animator') ?>';">
		</div>
		
	</div>
	
	
	<div id="viewers">
		<h1><?php echo __('Viewers List')?></h1>
		<table id="viewers_table" class="largeTable">
		  <thead>
		    <tr class="sortableTable">
		      <th><?php echo __('Name')?> <?php echo __('and')?> <?php echo __('Surname')?></th>
		      <th><?php echo __('E-mail')?></th>
		      <th style="width: 150px"><?php echo __('Login')?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php foreach ($moderators as $moderator): ?>
			    <?php if(!$moderator->getLogin()->getIsModerator()):?>
				    <tr>
					    <td>
					      	<a href="<?php echo url_for('moderator/edit?id='.$moderator->getId()) ?>">
					      		<?php echo $moderator->getName() ?> <?php echo $moderator->getSurname() ?>
					      	</a>
					    </td>
					    <td><?php echo $moderator->getEmail() ?></td>
					    <td><?php echo $moderator->getLogin()->getLogin() ?></td>
				    </tr>
			    <?php endif;?>
		    <?php endforeach; ?>
		  </tbody>
		</table>
	  	<div class="rightAlignement">
	    	<input type="button" value=<?php echo __('New')?> onClick="document.location.href='<?php echo url_for('moderator/new?type=viewer') ?>';">
		</div>
	</div>
</div>
