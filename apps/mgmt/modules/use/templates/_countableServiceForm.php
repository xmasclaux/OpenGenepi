<form action="<?php echo url_for('use/createCountableService')?>" method="post">
	<div class="panel">
		<table class="formTable">
			<tbody>
				<?php echo $form->renderGlobalErrors() ?>
				 <tr>
					<th><?php echo $form['imputation']['date']->renderLabel().' *'?></th>
					<td>
						<?php echo $form['imputation']['date']->renderError()?>
						<?php echo $form['imputation']['date']?>
					</td>
				</tr>
				
				<tr>
					<th><?php echo $form['imputation']['room_id']->renderLabel().' *'?></th>
					<td>
						<?php echo $form['imputation']['room_id']->renderError()?>
						<?php echo $form['imputation']['room_id']?>
					</td>
				</tr>
				
				<tr>
					<th><?php echo $form['imputation']['building_id']->renderLabel().' *'?></th>
					<td>
						<?php echo $form['imputation']['building_id']->renderError()?>
						<?php echo $form['imputation']['building_id']?>
					</td>
				</tr>
			      
			      <tr>
			      	<th></th>
				    <td>
				    	<hr></hr>	
				    </td>
		          </tr>
			      
			      <tr>
					<th><?php echo $form['imputation']['act_id']->renderLabel()?></th>
					<td>
						<?php echo $form['imputation']['act_id']->renderError()?>
						<?php echo $form['imputation']['act_id']?>
						<?php echo $form->getObject()->getImputation()->getAct()->getDesignation()?>
					</td>
				</tr>

				 <tr>
			      	<td><?php echo $form['imputation']['moderator_id']?></td>
			     </tr>
			      
			      <tr>
			      	<th></th>
				    <td>
				    	<hr></hr>	
				    </td>
		          </tr>
			      
			     <tr>
			     	<th><?php echo $form['initial_value']->renderLabel().' *'?></th>
			     	<td>
			     		<?php echo $form['initial_value']->renderError()?>
			     		<?php echo $form['initial_value']?>
			     		
			     		<?php echo $form['imputation']['unity_id']->renderError()?>
			     		<?php echo $form['imputation']['unity_id']?>
			     	</td>
			     </tr>
			     
			     <tr>
			     	<th><?php echo $form['imputation']['total']->renderLabel().' *'?></th>
			     	<td>
			     		<?php echo $form['imputation']['total']->renderError()?>
			     		<?php echo $form['imputation']['total'] ?><?php echo $currency_symbol?>
			     	</td>
			     </tr>
			       
			      <tr>
					<th></th>
					<td>
						<table style="border:none">
							<?php if($error_account):?>
								<tr>
									<td colspan="2">
										<div class="error-message-red"> 
											<span class="error-message-icon"></span> 
					            			<?php echo __('One or several accounts for the method of payment \'Account\' have not been specified')?>
					            		</div>
									</td>
								</tr>
								<tr>
								    <td colspan="2">
								    	<hr></hr>	
								    </td>
						        </tr>
							<?php endif;?>
							
							<tr>
								<th style="text-align:center"><?php echo $form['imputation']['user_id']->renderLabel()?></th>
								<th style="text-align:center"><?php echo $form['imputation']['method_of_payment_id']->renderLabel().' *'?></th>
							</tr>
							
							<tr>
								<td style="padding-right:20px">
									<?php echo $form['imputation']['user_id']->renderError()?>
									<?php echo $form['imputation']['user_id']?>
									<?php echo $form->getObject()->getImputation()->getUser()->getName()?>
									<?php echo $form->getObject()->getImputation()->getUser()->getSurname()?>
								</td>
								
						      	<td>
						      		<?php echo $form['imputation']['method_of_payment_id']->renderError()?>
						      		<?php echo $form['imputation']['method_of_payment_id']?>
			
						      		<?php echo $form['imputation']['account_id']->renderError()?>
						      		<?php echo $form['imputation']['account_id']?>&nbsp;<span id="status_text"><?php echo __('Actual status:')?></span>&nbsp;<span id="status"></span>
						      	</td>
				      		</tr>
				      		
				      		 <?php foreach($users_id as $user_id): ?>
				      		 	<tr>
							      	<th></th>
								    <td>
								    	<hr></hr>	
								    </td>
						        </tr>
					      		<tr>
					      			<td style="padding-right:20px">
							     		<?php echo $form['imputation']['user_id_'.$user_id]->renderError()?>
					      				<?php echo $form['imputation']['user_id_'.$user_id]?>
					      				
					      				<?php echo $users_names[$user_id]?>
							     	</td>
							     	
							     	<td>
							     		<?php echo $form['imputation']['method_of_payment_id_'.$user_id]->renderError()?>
					      				<?php echo $form['imputation']['method_of_payment_id_'.$user_id]?>
					      				
					      				<?php echo $form['imputation']['account_id_'.$user_id]->renderError()?>
						      			<?php echo $form['imputation']['account_id_'.$user_id]?>&nbsp;<span id="status_text_<?php echo $user_id?>"><?php echo __('Actual status:')?></span>&nbsp;<span id="status_<?php echo $user_id?>"></span>
							     	</td>
						     	</tr>
					        <?php endforeach;?>
				      	</table>
			      	</td>
			     </tr>
			     
			     <?php if($form->getOption('users', array()) != array()):?>
				     <tr>
				     	<th></th>
				     	<td>
				     		<table style="border:none">
				     			<tr>
				     				<td>
				     					<?php echo $form['account_is_shared']->renderError()?>
					     				<?php echo $form['account_is_shared']?>
				     				</td>
				     				<th><?php echo $form['account_is_shared']->renderLabel()?></th>
				     			</tr>
					   		</table>
				     	</td>
			  		 </tr>
			      <?php endif;?>
			      <tr>
			      	<th></th>
				    <td>
				    	<hr></hr>	
				    </td>
		          </tr>
			     
			     <tr>
			      	<th><?php echo $form['imputation']['comment']->renderLabel()?></th>
			      	<td>
			      		<?php echo $form['imputation']['comment']->renderError()?>
			      		<?php echo $form['imputation']['comment']?>
			      	</td> 
			     </tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<?php echo $form->renderHiddenFields() ?>
						<div class="rightAlignement"><input type="submit" value="<?php echo __('Save')?>" /></input></div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</form>


