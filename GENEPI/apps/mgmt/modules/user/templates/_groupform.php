<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('title', sprintf('GENEPI - '.__('Groups')))?>

<?php include_partial('global/messages')?>

<script type="text/javascript">

    function group_deletion()
    {
        $( "#dialog" ).dialog( {
            width: 600,
            close: false,
            resizable: false,
            modal: true,
            draggable: false
        } );
    }

    $(function() {

        $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
    });

</script>

<?php if (!$form->getObject()->isNew()): ?>
    <div id="dialog" title="<?php echo __("Group deletion")?>" style="display:none">
        <p><?php echo __("Caution, this group will be deleted.") ?></p>

        <input type="button" id="back-button" value=<?php echo __('Back')?>></input>

        <span class="deletion-button" style="float:right; margin-top:18px;">
            <?php echo link_to(__('Confirm'), 'user/groupdelete?id='.$groupId, array('method' => 'delete')) ?>
        </span>
    </div>
<?php endif; ?>

<?php slot('secondaryMenu') ?>
    <h2><?php echo __('Functionalities')?></h2>
    <h3><a href="<?php echo url_for('user/index') ?>"><?php echo __('List the users')?></a></h3>
    <h3><a href="<?php echo url_for('user/new') ?>"><?php echo __('Add an user')?></a></h3>
    <h3><a href="<?php echo url_for('user/anonymize') ?>"><?php echo __('Anonymize')?></a></h3>
    <h3><a href="<?php echo url_for('user/account') ?>"><?php echo __('Manage the accounts')?></a></h3>
    <h3><a href="<?php echo url_for('user/export') ?>"><?php echo __('Export')?></a></h3>
    <h3><a href="<?php echo url_for('user/groups') ?>"><?php echo __('List the groups')?></a></h3>
    <h3 class = "selected"><?php echo __('Add a group')?></h3>
<?php end_slot(); ?>

<form action="<?php echo url_for('user/group'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
          <th></th>
        <td colspan="2">
          <div class="rightAlignement">
              <input type="submit" value="<?php echo __('Save') ?>" />
          </div>
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('user/groups')?>';">
          <?php if (!$form->getObject()->isNew()): ?>
              <span class="deletion-button" onclick="group_deletion();">
                      <input type="button" value="<?php echo __('Delete')."..."?>"></input>
              </span>
          <?php endif; ?>
        </td>
      </tr>
    </table>
   </div>
</form>