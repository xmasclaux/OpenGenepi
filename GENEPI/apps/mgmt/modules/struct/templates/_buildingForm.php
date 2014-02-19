<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Building')))?>

<?php include 'secondaryMenu.php'?>

<script type="text/javascript">
	//Autocompletes the fields city and postal code when a suggestion is chosen
	function address_field_completion() {
		var address = document.getElementById('autocomplete_form_address_newAddress').value;

		if(address.indexOf("(") > 0)
		{
			document.getElementById('form_address_name').value = address.substring(0,address.indexOf("(",0)-1);
			document.getElementById('form_address_postal_code').value = address.substring(address.indexOf("(",0)+1,address.indexOf(")",0));
		}
		else
		{
			document.getElementById('form_address_name').value = address;
			document.getElementById('form_address_postal_code').value = "";
		}
		
		document.getElementById('form_address_address_city_id').value = document.getElementById('form_address_newAddress').value;

		if (document.getElementById('form_address_address_city_id').value == 0)
		{
			document.getElementById('form_address_address_city_id').value = 1;
		}
	}

	function show_hide_address(){
		if (document.getElementById('form_same_address').checked == true){
			$('#address').hide();
		}
		else {
			$('#address').show();
		}
	}

	function building_deletion(){
		$( "#dialog" ).dialog( { 
			width: 600,
			close: false,
			resizable: false,
			modal: true
		} );
	}
	
	$(document).ready( function () {

		document.getElementById('autocomplete_form_address_newAddress').value = "";
		
		if (document.getElementById('form_same_address'))
		{
			document.getElementById('form_same_address').onclick = show_hide_address;	
		}
		document.getElementById('autocomplete_form_address_newAddress').onblur = address_field_completion;
		});
</script>

<form action="<?php echo url_for('struct/'.($form->getObject()->isNew() ? 'createBuilding' : 'updateBuilding').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="panel">
  <table class="formTable">
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['designation']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['designation']->renderError() ?>
          <?php echo $form['designation'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['shortened_designation']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['shortened_designation']->renderError() ?>
          <?php echo $form['shortened_designation'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <?php if ($form->getObject()->isNew()): ?>
	      <tr>
	        <th><?php echo $form['same_address']->renderLabel() ?></th>
	        <td>
	          <?php echo $form['same_address']->renderError() ?>
	          <?php echo $form['same_address'] ?>
	        </td>
	      </tr>
      <?php endif; ?>
      <tr id="address" <?php if ($form->getObject()->isNew()): ?><?php echo "style =\"display:none;\""?><?php endif; ?>>
        <th><?php echo $form['address']->renderLabel() ?></th>
        <td>
          <?php echo $form['address'] ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;
          <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('struct/index#buildings') ?>';">
          <?php if (!$form->getObject()->isNew()): ?>
          		<span class="deletion-button" onclick="building_deletion();">
          			<input type="button" value="<?php echo __('Delete')."..."?>"></input>
          		</span>
  		  <?php endif; ?>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>