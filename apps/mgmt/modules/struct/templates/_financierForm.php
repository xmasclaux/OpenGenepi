<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php include_partial('global/messages')?>

<?php slot('title', sprintf('GENEPI - '.__('Financeur')))?>

<?php include 'secondaryMenu.php'?>

<form action="<?php echo url_for('struct/'.($form->getObject()->isNew() ? 'createFinancier' : 'updateFinancier').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      <tr>
      	<th><?php echo __('Logo') ?></th>
        <td>
          <?php if (!$form->getObject()->isNew()): ?>
          		<?php echo image_tag('/uploads/images/'.$financier->getLogoPath().'?'.microtime(), array('height' => '90', 'alt' => __('No Logo'))) ?>
          		<br /><br />
          <?php endif; ?>
          <?php echo $form['logo_path']->renderError() ?>
          <?php echo $form['logo_path'] ?>
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
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('struct/index#financiers') ?>';">
          <?php if (!$form->getObject()->isNew()): ?>
          		<span class="deletion-button"><?php echo link_to(__('Delete'), 'struct/deleteFinancier?id='.$form->getObject()->getId(), array('method' => 'delete')) ?></span>
  		  <?php endif; ?>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
  </table>
  </div>
</form>