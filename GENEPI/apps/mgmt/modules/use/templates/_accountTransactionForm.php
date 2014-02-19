<form action="<?php echo url_for('use/createAccountTransaction')?>" method="post">
	<div class="panel">
		<table class="formTable" style="width:100%">
			<tbody>
				<?php echo $form->renderGlobalErrors() ?>
				 <tr>
			      	<th style="width:20%"><?php echo $form['imputation']['date']->renderLabel().' *'?></th>
			      	<td>
			      		<?php echo $form['imputation']['date']->renderError()?>
			      		<?php echo $form['imputation']['date']?>
			      	</td> 
			     </tr>
				
			     <tr>
			      	<th style="width:20%"><?php echo $form['designation']->renderLabel()?></th>
			      	<td>
			      		<?php echo $form['designation']->renderError()?>
			      		<?php echo $form['designation']?>
			      	</td> 
			      </tr>
			      
			      <tr>
			      	<th style="width:20%"></th>
				    <td>
				    	<hr></hr>	
				    </td>
		          </tr>
			      
			      <tr>
					<th style="width:20%"><?php echo $form['imputation']['act_id']->renderLabel()?></th>
					<td>
						<?php echo __('Account Transaction')?>
					</td>
				  </tr>
				  
				  <tr>
			      	<th style="width:20%"><?php echo $form['imputation']['user_id']->renderLabel()?></th>
			      	<td>
			      		<?php echo $form['imputation']['user_id']->renderError()?>
			      		<?php echo $form['imputation']['user_id']?>
			      		<?php echo $form->getObject()->getImputation()->getUser()->getName()?>
			      		<?php echo $form->getObject()->getImputation()->getUser()->getSurname()?>
			      	</td> 
			      </tr>
			      
			      <tr>
			      	<th style="width:20%"></th>
				    <td>
				    	<hr></hr>	
				    </td>
		          </tr>
			      
			      <tr>
			      	<th style="width:20%"><?php echo $form['imputation']['account_id']->renderLabel().' *'?></th>
			      	<td>
			      		<?php echo $form['imputation']['account_id']->renderError()?>
			      		<?php echo $form['imputation']['account_id']?>&nbsp;<?php echo __('Actual status:')?>&nbsp;<span id="status"></span>
			      	</td> 
			      </tr>
			      
			      <tr id="free_nonfree_choose">
			      	<th style="width:20%"></th>
			      		<td>
			      			<table style="border:none;">
			      				<tr>
			      					<td><a id="nonfree_choose" style="font-weight:bold;"><?php echo __('Reloading')?></a></td>
			      					<td>&nbsp;/&nbsp;</td>
			      					<td><a id="free_choose"><?php echo __('Free outflow')?></a></td>
			      				</tr>
			      			</table>
						</td>
			      </tr>
			      
			      <tr><th style="width:20%"></th><td>
			      	<table style="padding:10px; width:430px">
			      			  <tr id="free_input" style="display:none">
						      	
						      	<td><span><?php echo __('Quantity')?>:<?php echo $form['quantity']?></span><span id="free_account_unity"></span></td>
						      </tr>
						      
						      <tr id="nonfree_input_info">
						      	
						      	<td>
						      		<div class="info-message-white">
			    						<span class="info-message-icon"></span>
										<em><?php echo __('The below total is calculated automatically but you can modify it.')?><br></em>
				        			</div>      
						      	</td>
						      </tr>
			
						      <tr id="nonfree_input">
						      	
								<td>
									<table style="border:none; width:100%">
										<tr>
											<td style="text-align:center"><?php echo $form['sum']->renderLabel().' *'?></td>
											<td style="text-align:center">x</td>
											<td style="text-align:center"><?php echo $form['unitary_price']->renderLabel().' *'?></td> 
											<td style="text-align:center">=</td>
											<td style="text-align:center"><?php echo $form['imputation']['total']->renderLabel().' *'?></td>
										</tr>
										<tr>
											<td>
												<?php echo $form['sum']?>
												
												<?php echo $form['imputation']['unity_id']?>
												
											</td>
											<td style="text-align:center">x</td>
											<td>
												<?php echo $form['unitary_price']?>
											</td>
											<td style="text-align:center">=</td>
											<td>
												<?php echo $form['imputation']['total']?>
											</td>
											<td>
												<?php echo $form->getObject()->getImputation()->getUnity()->getShortenedDesignation();?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo $form['sum']->renderError()?>
												<?php echo $form['imputation']['unity_id']->renderError()?>
											</td>
											<td></td>
											<td>
												<?php echo $form['unitary_price']->renderError()?>
											</td>
											<td></td>
											<td>
												<?php echo $form['imputation']['total']->renderError()?>
											</td>
										</tr>
									</table>
								</td>
							  </tr>
							  
							  <?php if($error_account):?>
								<tr>
									
									<td>
										<div class="error-message-red"> 
											<span class="error-message-icon"></span> 
					            			<?php echo __('The account for the method of payment \'Account\' is compulsory')?>
					            		</div>
									</td>
								</tr>
								<tr>
									<th style="width:20%"></th>
								    <td>
								    	<hr></hr>	
								    </td>
						        </tr>
							  <?php endif;?>
						      
						      <tr id="nonfree_input_to_pay">
						      	
						      	<td>
							      	<table style="border:none; width:100%"><tr>
								      	<td><?php echo $form['imputation']['method_of_payment_id']->renderLabel().' *'?></td>
								      	<td>
								      		<?php echo $form['imputation']['method_of_payment_id']->renderError()?>
								      		<?php echo $form['imputation']['method_of_payment_id']?>
					
								      		<?php echo $form['account_to_pay_id']->renderError()?>
								      		<?php echo $form['account_to_pay_id']?>
								      	</td> 
							      	</tr></table>
						      	</td>
						      </tr>
			      	</table>
			      </td></tr>
			      
			      
			      
			      <tr>
			      	<th style="width:20%"></th>
				    <td>
				    	<hr></hr>	
				    </td>
		          </tr>
			     
			     <tr>
			      	<td><?php echo $form['imputation']['moderator_id']?></td>
			     </tr>
			     
			     <tr>
			      	<th style="width:20%"><?php echo $form['imputation']['comment']->renderLabel()?></th>
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