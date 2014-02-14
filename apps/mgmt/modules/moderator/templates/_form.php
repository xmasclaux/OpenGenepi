<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript">
	function moderator_deletion(){
			$( "#dialog" ).dialog( { 
				width: 600,
				close: false,
				resizable: false,
				modal: true
			} );
		}
</script>

<?php include 'secondaryMenu.php'?>



<form action="<?php echo url_for('moderator/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="panel">
  <table class="formTable" id="content">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<input type="button" value=<?php echo __('Back')?> onClick="document.location.href='<?php echo url_for('moderator/index'.($form->getObject()->getLogin()->getIsModerator() ? '#animators' : '#viewers'))?>';">
          <?php if (!$form->getObject()->isNew() && !$is_myself): ?>
          		<span class="deletion-button" onclick="moderator_deletion();">
          			<input type="button" value="<?php echo __('Delete')?>..."></input>
          		</span>
  		  <?php endif; ?>
          <div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
        </td>
      </tr>
    </tfoot>
    <tbody>
    
      <tr>
      	<th></th>
      	<td>
      		<?php if (!$form->getObject()->isNew() && $is_myself): ?>
				<div class="info-message-white">
    				<span class="info-message-icon"></span>
					<em><?php echo __('Info: You cannot delete your own account.')?><br></em>	
				</div>        
			<?php endif; ?>
      	</td>
      </tr>
    
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
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>
      
      <tr>
        <th><?php echo $form['login']['is_moderator']->renderLabel() ?></th>
        <td>
         	<?php echo $form['login']['is_moderator']->renderError() ?>
          	<?php echo $form['login']['is_moderator'] ?><?php echo $form['login']['id'] ?>
        </td>
        <?php if ($form->getObject()->isNew()): ?>
	        <td>
	        	<div class="info-message-white">
    				<span class="info-message-icon"></span>
					<em><?php echo __('You are about to add a moderator of type: ')?><br></em>
		        	<?php if($isModerator):?>
		        	 	<em><?php echo __('Administrator')?></em>
		        	<?php else:?>
		        	 	<em><?php echo __('Viewer')?></em>
		        	<?php endif;?>	
	        	</div>        	 	
	        </td>
        <?php endif;?>
      </tr>
      
      <tr>
      	<th></th>
	    <td>
	    	<hr></hr>	
	    </td>
      </tr>

      <tr>
        <th><?php echo $form['login']['login']->renderLabel().' *' ?></th>
        <td>
          <?php echo $form['login']['login']->renderError() ?>
          <?php echo $form['login']['login'] ?>
        </td>
        <?php if ($form->getObject()->isNew()): ?>
        <td>
        	<div class="info-message-white">
    			<span class="info-message-icon"></span>
				<em><?php echo __('Caution: once you choose a login, you won\'t be able to edit it.')?><br></em>	
        	</div>        	 	
	    </td>
	    <?php else:?>
	    <td>
        	<div class="info-message-white">
    			<span class="info-message-icon"></span>
				<em><?php echo __('The login modification is not available.')?><br></em>	
        	</div> 
        	<input id="password_change" type="hidden" name="password_change" value="0"/>       	 	
	    </td>
	    <?php endif;?>
      </tr>
      
      
      <tr>
      	<?php if (!$form->getObject()->isNew()): ?>
	      	<th><?php echo __('Password change')?></th>
	      	<td id="cancel_change"><a id="link_change_pass" href="#change_pass"><?php echo __('Change password')?></a></td>
      </tr>
      	<?php else:?>
      <tr>
     		<th><?php echo __('Password').' *'?></th>
	      	<td>
				 <?php echo $form['login']['password']->renderError() ?>
	         	 <?php echo $form['login']['password'] ?>
			</td>
			<td rowspan=2>
	        	<div class="info-message-white">
	    			<span class="info-message-icon"></span>
					<em><?php echo __('Please enter your password twice.')?><br></em>	
	        	</div>        	 	
	    	</td>
		 </tr>
		 <tr>
			<th><?php echo $form['login']['password_confirm']->renderLabel().' *'?></th>
	      	<td>
				 <?php echo $form['login']['password_confirm']->renderError() ?>
	         	 <?php echo $form['login']['password_confirm'] ?>
			</td>
		</tr>
      	<?php endif;?>
     

    </tbody>
  </table>
  </div>
  <input type="text" name="type" value="<?php echo __($_GET['type'])?>" style="display:none"></input>
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