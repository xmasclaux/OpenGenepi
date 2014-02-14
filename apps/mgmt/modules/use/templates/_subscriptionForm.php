<form action="<?php echo url_for('use/createSubscription')?>" method="post">
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
					<td>
						<?php echo $form['number_of_members']?>
					</td>
				</tr>

				<tr>
					<th><?php echo $form['imputation']['total']->renderLabel().' *'?></th>
					<td>
						<?php echo $form['imputation']['total']->renderError()?>
						<?php echo $form['imputation']['total']?>

						<?php echo $form['imputation']['unity_id']->renderError()?>
						<?php echo $form['imputation']['unity_id']?>
						<?php echo $form->getObject()->getImputation()->getUnity()->getShortenedDesignation();?>
					</td>
				</tr>

			     <tr>
					<th><?php echo $form['final_date']->renderLabel().' *'?></th>
					<td>
						<?php echo $form['final_date']->renderError()?>
						<?php echo $form['final_date']?>
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

<input id="duration" name="duration" type="hidden" value="<?php echo $duration?>"></input>

<?php
// -----------------------------------------------------------------------------------------------------------
// KYXAR 0002 - 29/06/2011
// Calcul de la date de fin à partir de la date de départ et de la durée et vice-versa
 ?>
<script type='text/javascript'>

$(function() {

    $('#imputation_subscription_imputation_date_day, #imputation_subscription_imputation_date_month, #imputation_subscription_imputation_date_year').change(function() {

        var d_day =     parseInt($('#imputation_subscription_imputation_date_day').val(), 10);
        var d_month =   parseInt($('#imputation_subscription_imputation_date_month').val(), 10);
        var d_year =    parseInt($('#imputation_subscription_imputation_date_year').val(), 10);

        var tab =       $('#duration').val().split(':');
        var d =         new Date(d_year + parseInt(tab[4], 10), d_month - 1 + parseInt(tab[3], 10), d_day + parseInt(tab[2], 10), 0, 0, 0, 0);

        d_day =         d.getDate();
        d_month =       d.getMonth() + 1;
        d_year =        d.getFullYear();

        $('#imputation_subscription_final_date_day').val(d_day);
        $('#imputation_subscription_final_date_month').val(d_month);
        $('#imputation_subscription_final_date_year').val(d_year);
    });

    $('#imputation_subscription_final_date_day, #imputation_subscription_final_date_month, #imputation_subscription_final_date_year').change(function() {

        var d_day =     parseInt($('#imputation_subscription_final_date_day').val(), 10);
        var d_month =   parseInt($('#imputation_subscription_final_date_month').val(), 10);
        var d_year =    parseInt($('#imputation_subscription_final_date_year').val(), 10);

        var tab =       $('#duration').val().split(':');
        var d =         new Date(d_year - parseInt(tab[4], 10), d_month - 1 - parseInt(tab[3], 10), d_day - parseInt(tab[2], 10), 0, 0, 0, 0);

        d_day =         d.getDate();
        d_month =       d.getMonth() + 1;
        d_year =        d.getFullYear();

        $('#imputation_subscription_imputation_date_day').val(d_day);
        $('#imputation_subscription_imputation_date_month').val(d_month);
        $('#imputation_subscription_imputation_date_year').val(d_year);
    });
});

</script>

<?php
// FIN KYXAR 29/06/2011
// -----------------------------------------------------------------------------------------------------------
?>