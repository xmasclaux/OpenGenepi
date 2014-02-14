<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Structure')))?>

<?php include 'secondaryMenu.php'?>

<h1><?php echo __('Edit structure')?></h1>

<script type="text/javascript">
	//Autocompletes the fields city and postal code when a suggestion is chosen
	function address_field_completion() {
		var address = document.getElementById('autocomplete_form_address_newAddress').value;
		document.getElementById('form_address_name').value = address.substring(0,address.indexOf("(",0)-1);
		document.getElementById('form_address_postal_code').value = address.substring(address.indexOf("(",0)+1,address.indexOf(")",0));
		document.getElementById('form_address_address_city_id').value = document.getElementById('form_address_newAddress').value;
		if (document.getElementById('form_address_address_city_id').value == 0)
		{
			document.getElementById('form_address_address_city_id').value = 1;
		}
	}
	
	$(document).ready( function () {
		document.getElementById('autocomplete_form_address_newAddress').onblur = address_field_completion;
	});
</script>

<form action="<?php echo url_for('struct/'.($form->getObject()->isNew() ? 'createStructure' : 'updateStructure').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="panel">
  <table class="formTable">
    <tfoot>
      <tr>
        <th></th>
        <td>
          <?php echo $form->renderHiddenFields(false) ?>
          <br />
          <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('struct/index') ?>';">
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></div>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo __('Logo') ?></th>
        <td>
          <div class="restrict-picture-size">
          	<?php echo image_tag('/uploads/images/logo.png?'.microtime(), array('height' => '90', 'alt' => __('No Logo'))) ?>
          </div>
          <br />
      	  <?php echo $form['logo_path']->renderError() ?>
          <?php echo $form['logo_path'] ?>
          <br />
		  <div class="info-message" style="margin-top:10px;">
		    <span class="info-message-icon"></span>
		    <em><?php echo __('Caution, the new logo will erase the current one. It will be resized in height.')?></em>
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
        <th><?php echo $form['name']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['website']->renderLabel() ?></th>
        <td>
          <?php echo $form['website']->renderError() ?>
          <?php echo $form['website'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['address']->renderLabel() ?></th>
        <td>
          <?php echo $form['address'] ?>
        </td>
      </tr>
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
        <th><?php echo $form['telephone_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['telephone_number']->renderError() ?>
          <?php echo $form['telephone_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['siret_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['siret_number']->renderError() ?>
          <?php echo $form['siret_number'] ?>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
</form>