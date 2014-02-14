<?php echo "toto" ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('title', sprintf('GENEPI - '.__('Reservations')))?>

<?php include_partial('global/messages')?>

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
        <td>
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
      <tr>
          <th></th>
        <td>
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