<?php slot('title', sprintf('GENEPI - '.__('Configuration')))?>

<h1><?php echo __('GENEPI configuration')?></h1>

<div id="explanationChecked">
	<?php echo "<u>".__("Step 1:")."</u>"." ".__("Database parameters") ?>
</div>
<br />
<div id="explanationChecked">
	<?php echo "<u>".__("Step 2:")."</u>"." ".__("Structure parameters") ?>
</div>
<br />
<div id="explanation">
	<?php echo "<u>".__("Step 3:")."</u>"." ".__("Creation of a new user") ?>
</div>

<head>
	<script type="text/javascript">
		$(document).ready(function(){

			//Add an event on the blur of the field 'name'
			$("input[name='moderator[name]']").blur(function(){

				if($(this).val() != '' && $("input[name='moderator[surname]']").val() != ''){			
					var name = $(this).val();
					var surname = $("input[name='moderator[surname]']").val();
					var login = name.toLowerCase().substr(0,1) + surname.toLowerCase();
					$("input[name='moderator[login][login]']").val(login);
				}
				
			});

			//Add an event on the blur of the field 'surname'
			$("input[name='moderator[surname]']").blur(function(){
				
				if($(this).val() != '' && $("input[name='moderator[name]']").val() != ''){
					var surname = $(this).val();
					var name = $("input[name='moderator[name]']").val();
					var login = name.toLowerCase().substr(0,1) + surname.toLowerCase();
					$("input[name='moderator[login][login]']").val(login);
				}
			});
		});
	</script>
</head>


<form action="<?php echo url_for('firstBoot/createNewUser')?>" method="post">
	<div class="panel">
	  <table class="formTable" id="content">
	   <tbody>
	      
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
	        <th><?php echo $form['login']['login']->renderLabel().' *' ?></th>
	        <td>
	          <?php echo $form['login']['login']->renderError() ?>
	          <?php echo $form['login']['login'] ?>
	        </td>
	        <td>
	        	<div class="info-message-white">
	    			<span class="info-message-icon"></span>
					<em><?php echo __('Caution: once you choose a login, you won\'t be able to edit it.')?><br></em>	
	        	</div>        	 	
		    </td>
	      </tr>
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
	    </tbody>
	  </table>
	  <div class="rightAlignement"><input type="submit" value="<?php echo __('Save and achieve configuration')?>" /></input></div>
	  <br /><br /><br />
	</div>
	<?php echo $form->renderHiddenFields(false) ?>
</form>

<?php if ($sf_user->hasFlash('error')): ?>
 	<div class="feedback-error-message"> 
  		<span class="error-message-icon"></span> 
    	<?php echo __($sf_user->getFlash('error')) ?>
 	</div>
<?php endif; ?>  