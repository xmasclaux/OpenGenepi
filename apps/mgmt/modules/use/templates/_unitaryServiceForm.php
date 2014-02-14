<form action="<?php echo url_for('use/createUnitaryService')?>" method="post">
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
					<th></th>
					<td>
						<table style="border:none">
							<tr>
								<th style="text-align:center"><?php echo $form['number_of_unities']->renderLabel().' *'?></th>
								<th style="text-align:center">x</th>
								<th style="text-align:center"><?php echo $form['unitary_price']->renderLabel().' *'?></th>
								<th style="text-align:center">=</th>
								<th style="text-align:center"><?php echo $form['imputation']['total']->renderLabel().' *'?></th>
							</tr>
							<tr>
								<td>
									<?php echo $form['number_of_unities']?>
								</td>
								<td style="text-align:center">x</td>
								<td>
									<?php echo $form['unitary_price']?>
								</td>
								<td style="text-align:center">=</td>
								<td>
									<?php echo $form['imputation']['total']?>

									<?php echo $form['imputation']['unity_id']?>
									<?php echo $form->getObject()->getImputation()->getUnity()->getShortenedDesignation();?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $form['number_of_unities']->renderError()?>
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

			     <tr>
			     	<th><?php echo $form['beginning_time']->renderLabel().' *'?></th>

			     	<td rowspan="2">
			     		<table style="border:none">
			     			<tr>
								<td>
									<?php echo $form['beginning_time']->renderError()?>
									<?php echo $form['beginning_time']?>
								</td>

								<td rowspan="3" align=left>
									&nbsp;&nbsp;&nbsp;
									<a id="begin_time_now" href="javascript:;"><?php echo __('Starts Now')?></a>
									&nbsp;-&nbsp;
									<a id="end_time_now" href="javascript:;"><?php echo __('Ends Now')?></a>
								</td>
							</tr>

							<tr>
								<td>&nbsp;</td>
							</tr>

							<tr>
								<td>
									<?php echo $form['end_time']->renderError()?>
									<?php echo $form['end_time']?>
								</td>
							</tr>
						</table>
					</td>
				 </tr>

				 <tr>
				 	<th><?php echo $form['end_time']->renderLabel().' *'?></th>
				 </tr>

			      <tr>
					<th></th>
					<td>
						<table style="border:none">
							<?php if($error_account):?>
								<tr>
									<td colspan="3">
										<div class="error-message-red">
											<span class="error-message-icon"></span>
					            			<?php echo __('One or several accounts for the method of payment \'Account\' have not been specified')?>
					            		</div>
									</td>
								</tr>
								<tr>
								    <td colspan="3">
								    	<hr></hr>
								    </td>
						        </tr>
							<?php endif;?>

							<tr>
								<th style="text-align:center"><?php echo $form['imputation']['user_id']->renderLabel()?></th>
								<th style="text-align:center"><?php echo $form['imputation']['method_of_payment_id']->renderLabel().' *'?></th>
								<th style="text-align:center"><?php echo $form['computer_id']->renderLabel().' *'?></th>
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

						      	<td>
						      		<?php echo $form['computer_id']->renderError()?>
						      		<?php echo $form['computer_id']?>
						      	</td>
				      		</tr>

				      		 <?php foreach($users_id as $user_id): ?>
				      		 	<tr>
							      	<th></th>
								    <td>
								    	<hr></hr>
								    </td>
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

							     	<td>
							      		<?php echo $form['computer_id_'.$user_id]->renderError()?>
							      		<?php echo $form['computer_id_'.$user_id]?>
						      		</td>
						     	</tr>
					        <?php endforeach;?>
				      	</table>
			      	</td>
			     </tr>

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
	<input name="act_public_category_id" type="hidden" value="<?php echo $act_public_category_id?>"></input>
</form>

<input id="duration" type="hidden" value="<?php echo $duration?>"></input>