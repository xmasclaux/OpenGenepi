<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Computer')))?>

<?php include 'secondaryMenu.php'?>

<script language="javascript">
$(document).ready(function(){
  $("#computer_computer_os_family_id").change( function() {
    $.post('<?php echo url_for('struct/AjaxOsName') ?>', { family: $(this).val() },
    function(data){
      $('#computer_os').show('fast');
      $("#computer_computer_os_id").html(data);
      
      if (document.getElementById("computer_computer_os_id").length == 1)
      {
    	  $('#computer_os').hide();
      }
    });
  });
});
</script>

<form action="<?php echo url_for('struct/'.($form->getObject()->isNew() ? 'createComputer' : 'updateComputer').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="panel">
  <table class="formTable">
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['shortened_name']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['shortened_name']->renderError() ?>
          <?php echo $form['shortened_name'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['computer_machine_type_id']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['computer_machine_type_id']->renderError() ?>
          <?php echo $form['computer_machine_type_id'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['computer_type_of_connexion_id']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['computer_type_of_connexion_id']->renderError() ?>
          <?php echo $form['computer_type_of_connexion_id'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['computer_os_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['computer_os_family_id']->renderError() ?>
          <?php echo $form['computer_os_family_id'] ?>
        <div id="computer_os" <?php if ($form->getObject()->isNew()): ?> style ="display:none;"  <?php endif;?>>
          <?php echo $form['computer_os_id']->renderError() ?>
          <?php echo $form['computer_os_id'] ?>
        </div>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['ip_address']->renderLabel() ?></th>
        <td>
          <?php echo $form['ip_address']->renderError() ?>
          <?php echo $form['ip_address'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mac_address']->renderLabel() ?></th>
        <td>
          <?php echo $form['mac_address']->renderError() ?>
          <?php echo $form['mac_address'] ?>
          <br />
		  <div class="info-message-green" style="margin-top:5px;">
		  <span class="info-message-icon"></span>
			<em><?php echo __('Unique identifier of the network interface.')?><br/></em>
			<em><?php echo __('To learn more, click ')?></em>
			<?php if (!strcmp($culture,"fr")): ?>
				<em><a href="http://fr.wikipedia.org/wiki/Adresse_MAC" target="_blank" style="font-weight: bold;" ><?php echo __('here') ?></a></em>
		 	<?php else: ?>
		 		<em><a href="http://en.wikipedia.org/wiki/MAC_address" target="_blank" style="font-weight: bold;" ><?php echo __('here') ?></a></em>
		 	<?php endif;?>
		  </div>
	    </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['year']->renderLabel() ?></th>
        <td>
          <?php echo $form['year']->renderError() ?>
          <?php echo $form['year'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['room_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['room_id']->renderError() ?>
          <?php echo $form['room_id'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['comment']->renderLabel() ?></th>
        <td>
          <?php echo $form['comment']->renderError() ?>
          <?php echo $form['comment'] ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('struct/index#computers') ?>';">
          <?php if (!$form->getObject()->isNew()): ?>
          		<span class="deletion-button"><?php echo link_to(__('Delete'), 'struct/deleteComputer?id='.$form->getObject()->getId(), array('method' => 'delete')) ?></span>
  		  <?php endif; ?>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>