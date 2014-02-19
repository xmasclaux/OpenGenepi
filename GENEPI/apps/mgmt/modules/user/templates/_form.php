<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('title', sprintf('GENEPI - '.__('Users')))?>

<?php include_partial('global/messages')?>

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

    function user_deletion(){
        $( "#dialog" ).dialog( {
            width: 600,
            close: false,
            resizable: false,
            modal: true,
            draggable: false
        } );
    }

    $(document).ready( function () {
        document.getElementById('autocomplete_form_address_newAddress').value = "";

        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );

        document.getElementById('autocomplete_form_address_newAddress').onblur = address_field_completion;

        $("#direct_imputation").click ( function() {
            document.getElementById('form_direct_imputation').value = "1";
        } );
    });
</script>

<?php if (!$form->getObject()->isNew()): ?>
    <div id="dialog" title="<?php echo __("User deletion")?>" style="display:none">
        <p><?php echo __("Caution, this user and all his personnal data will be deleted.") ?></p>
        <p><?php echo __("His acts will be anonymized but kept in memory.") ?></p>

        <input type="button" id="back-button" value=<?php echo __('Back')?>></input>

        <span class="deletion-button" style="float:right; margin-top:18px;">
            <?php echo link_to(__('Confirm'), 'user/delete?id='.$userId.'&address='.$form->getObject()->getAddressId(), array('method' => 'delete')) ?>
        </span>
    </div>
<?php endif; ?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('user/index') ?>"><?php echo __('List the users')?></a></h3>
    <h3 class = "selected"><?php echo __('Add an user')?></h3>
    <h3><a href="<?php echo url_for('user/anonymize') ?>"><?php echo __('Anonymize')?></a></h3>
    <h3><a href="<?php echo url_for('user/account') ?>"><?php echo __('Manage the accounts')?></a></h3>
    <h3><a href="<?php echo url_for('user/export') ?>"><?php echo __('Export')?></a></h3>
    <h3><a href="<?php echo url_for('user/groups') ?>"><?php echo __('Groups')?></a></h3>
<?php end_slot(); ?>

<form action="<?php echo url_for('user/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
        <th><?php echo $form['surname']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['surname']->renderError() ?>
          <?php echo $form['surname'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['organization_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['organization_name']->renderError() ?>
          <?php echo $form['organization_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['birthdate']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['birthdate']->renderError() ?>
          <?php echo $form['birthdate'] ?>
        </td>
      </tr>
      <tr>
          <th></th>
        <td colspan=2>
            <hr></hr>
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
        <th><?php echo $form['cellphone_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['cellphone_number']->renderError() ?>
          <?php echo $form['cellphone_number'] ?>
        </td>
      </tr>
          <th></th>
        <td colspan=2>
            <hr></hr>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['user_gender_id']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['user_gender_id']->renderError() ?>
          <?php echo $form['user_gender_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['user_seg_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['user_seg_id']->renderError() ?>
          <?php echo $form['user_seg_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['user_awareness_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['user_awareness_id']->renderError() ?>
          <?php echo $form['user_awareness_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['act_public_category_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['act_public_category_id']->renderError() ?>
          <?php echo $form['act_public_category_id'] ?>
        </td>
      </tr>
      <tr>
          <th></th>
        <td colspan=2>
            <hr></hr>
        </td>
      </tr>

      
      <tr>
      	<th><?php echo $form['login']['login']->renderLabel() ?></th>
      	<td>
      	  <?php echo $form['login']['login']->renderError() ?>
      	  <?php echo $form['login']['login'] ?>
      	  <?php echo $form['login']['id'] ?>
      	  <?php echo $form['login']['is_moderator'] ?>
        </td>
        <td>

      	</td>
      </tr>
      <tr>
      	<?php if (!$form->getObject()->isNew()): ?>
	      	<th><?php echo __('Password change')?></th>
	      	<td id="cancel_change"><a id="link_change_pass" href="#change_pass"><?php echo __('Change password')?></a></td>
	      	<input id="password_change" type="hidden" name="password_change" value="0"/> 
      </tr>
      
      	<?php else:?>
      	<th><?php echo __('Password') ?></th>
      	<td>
      		<?php echo $form['login']['password']->renderError() ?>
      		<?php echo $form['login']['password'] ?>
      	</td>
      	<td>
      	  <div class="info-message-white">
	    			<span class="info-message-icon"></span>
					<em><?php echo __('Please enter your password twice.')?><br></em>	
	      </div>        
      	</td>
      </tr>
      <tr>
      	<th></th>
      	<td>
      	  <?php echo $form['login']['password_confirm']->renderError() ?>
	      <?php echo $form['login']['password_confirm'] ?>
      	</td>
      </tr>
        <?php endif;?>
      
      <tr>
          <th></th>
        <td colspan=2>
            <hr></hr>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['address']->renderLabel() ?></th>
        <td colspan=2>
          <?php echo $form['address'] ?>
        </td>
      </tr>
      
      <tr>
          <th></th>
        <td colspan=2>
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
      <tr>
          <th></th>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('user/index')?>';">
          <?php if (!$form->getObject()->isNew()): ?>
              <span class="deletion-button" onclick="user_deletion();">
                      <input type="button" value="<?php echo __('Delete')."..."?>"></input>
              </span>
          <?php endif; ?>
          <div class="rightAlignement">
              <input type="submit" value="<?php echo __('Save') ?>" />
          </div>
          <div class="rightAlignement">
              <input type="submit" id="direct_imputation" value="<?php echo __('Save and impute an act') ?>" />
          </div>
        </td>
      </tr>
    </table>
   </div>
</form>

<?php if (!$form->getObject()->isNew()): ?>
	<table id="change_content" style="display:none">
	      <tr>
	      	<th><?php echo $form['login']['password']->renderLabel().' *' ?></th>
	        <td>
	          <?php echo $form['login']['password']->renderError() ?>
	          <?php echo $form['login']['password'] ?>
	        </td>
	      </tr>
	      <tr>
			<th><?php echo $form['login']['password_confirm']->renderLabel().' *'?></th>
	      	<td>
				 <?php echo $form['login']['password_confirm']->renderError() ?>
	         	 <?php echo $form['login']['password_confirm'] ?>
			</td>
		</tr>
	      <tr>
	      	<td colspan="3"><div class="rightAlignement"><a id="link_cancel_change" href="#cancel_change"><?php echo __('Cancel change')?></a></div></td>
	      </tr>
	</table>
	
	<div id="cancel_change_content" style="display:none"><a id="link_change_pass" href="#change_pass"><?php echo __('Change password')?></a></div>
<?php endif;?>