<?php slot('title', sprintf('GENEPI - '.__('Configuration')))?>

<h1><?php echo __('GENEPI configuration')?></h1>

<div id="explanationChecked">
	<?php echo "<u>".__("Step 1:")."</u>"." ".__("Database parameters") ?>
</div>
<br />
<div id="explanation">
	<?php echo "<u>".__("Step 2:")."</u>"." ".__("Structure parameters") ?>
</div>

<div class="panel">
	<form action="<?php echo url_for('firstBoot/updateStructure') ?>" method="post" >
		  <table class="formTable">
		    <tbody>
		      <tr>
		        <th><?php echo __('Structure name').' *'?></th>
		        <td>
		          <input name="structure_name" type ="text">
		        </td>
		      </tr>
		    </tbody>
		  </table>
    	<input type="submit" class="rightAlignement" value="<?php echo __('Continue')?>">
	</form>
</div>

<?php if ($sf_user->hasFlash('error')): ?>
 	<div class="feedback-error-message"> 
  		<span class="error-message-icon"></span> 
    	<?php echo __($sf_user->getFlash('error')) ?>
 	</div>
<?php endif; ?>  