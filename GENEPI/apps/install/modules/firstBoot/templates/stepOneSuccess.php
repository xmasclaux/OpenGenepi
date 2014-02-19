<?php slot('title', sprintf('GENEPI - '.__('Configuration')))?>

<head>
	<script type="text/javascript">
	  $(document).ready(function() { 
	
		$("input[name='srv_port']").val('3306'); 
		   
	    $("select[name='dbms']").change(function(){
			var dbms = $("select[name='dbms'] option:selected").val();
			if(dbms == "mysql"){
				$("input[name='srv_port']").val('3306'); 
			}else if(dbms == "pgsql"){
				$("input[name='srv_port']").val('5432'); 
			}
	  	});
	  });
	</script>
</head>    

<h1><?php echo __('GENEPI configuration')?></h1>

<div id="explanation">
	<?php echo "<u>".__("Step 1:")."</u>"." ".__("Database parameters") ?>
</div>

    <div id="system">
   
    <?php echo $form->renderGlobalErrors()?>
    <form method="post" action="<?php echo url_for('firstBoot/systemParameters')?>">
        <table class="formTable">
        	<tr>
        	<th style="text-align: center;"><label><?php echo __('Server')?></label></th>
        	
        	<td><table class="formTable">
	        	<tr valign=middle>
	        		<th><label><?php echo $form['ip_address']->renderLabel()?>:</label></th>
	        		<td>
		        		<?php echo $form['ip_address']->renderError() ?>
		        		<?php echo $form['ip_address']?>
	        		</td>
	        		<td>
    					<div class="info-message-white">
		    				<span class="info-message-icon"></span>
							<em><?php echo __('If the database server is on the same server than the application, type "localhost" or "127.0.0.1"')?><br /></em>
						</div>
    				</td>
	        	</tr>
	        	<tr>
	        		<th><label><?php echo $form['srv_port']->renderLabel()?>:</label></th>
	        		<td>
		        		<?php echo $form['srv_port']->renderError() ?>
		        		<?php echo $form['srv_port']?>
	        		</td>
	        		<td>
    					<div class="info-message-white">
		    				<span class="info-message-icon"></span>
							<em><?php echo __('Default ports: 3306 for MySQL and 5432 for PostgreSQL')?><br /></em>
						</div>
    				</td>
	        	</tr>
        	</table></td>
        	</tr>
        	<tr>
        		<th style="text-align: center;"><label><?php echo __('Database')?></label></th>
	        	<td><table class="formTable">
		        	<tr valign=middle>
		        		<th><label><?php echo $form['dbms']->renderLabel()?>:</label></th>
		        		<td>
		        			<?php echo $form['dbms']->renderError() ?>
	        				<?php echo $form['dbms']?>
		        		</td>
		        	</tr>
		        	<tr>
		        		<th><label><?php echo $form['db_name']->renderLabel()?>:</label></th>
		        		<td>
			        		<?php echo $form['db_name']->renderError() ?>
		        			<?php echo $form['db_name']?>
		        		</td>
		        		<td>
    					<div class="info-message-white">
		    				<span class="info-message-icon"></span>
							<em><?php echo __('The default name of the database is GENEPI')?><br /></em>
						</div>
    				</td>
		        	</tr>
		        	<tr>
		        		<th><label><?php echo $form['db_user_name']->renderLabel()?>:</label></th>
		        		<td>
			        		<?php echo $form['db_user_name']->renderError() ?>
		        			<?php echo $form['db_user_name']?>
		        		</td>
		        		<td rowspan=2 >
    					<div class="info-message-white">
		    				<span class="info-message-icon"></span>
							<em><?php echo __('It is recommanded to use a login and a password dedicated to GENEPI')?><br /></em>
						</div>
    				</td>
		        	</tr>
		        	<tr>
		        		<th><label><?php echo $form['db_password']->renderLabel()?>:</label></th>
		        		<td>
			        		<?php echo $form['db_password']->renderError() ?>
		        			<?php echo $form['db_password']?>
		        		</td>
		        	</tr>
		        </table></td>
        	</tr>
        </table>
        <br>
        <?php echo $form->renderHiddenFields(); ?>
        <input type="submit" class="rightAlignement" value="<?php echo __('Continue')?>">
    </form>
    <br />
</div>
  
<?php if ($sf_user->hasFlash('error')): ?>
 	<div class="feedback-error-message"> 
  		<span class="error-message-icon"></span> 
    	<?php echo __($sf_user->getFlash('error')) ?>
 	</div>
<?php endif; ?>  