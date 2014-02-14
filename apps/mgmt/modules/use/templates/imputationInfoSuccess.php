<p style="font-weight: bold";>
	<?php echo __($imputationType)." - ".date_format(new DateTime($imputation->getDate()), __('m-d-Y').' H:i');?>
</p>

<table class="largeTable">
	<?php if($imputation->getActId() != null):?>
		<tr><td>
			<?php echo __('Act name')." : ".$imputation->getAct()?>
		</td></tr>
	<?php endif;?>

	<tr>
		<td>
			<?php if($imputation->getUserId() != null):?>
				<?php echo __('User')." : ".$imputation->getUser()?>
			<?php else:?>
				<?php echo __('Anonymized user')?>
			<?php endif;?>
		</td>
	</tr>
	
	<?php if($imputation->getTotal() != ""):?>
		<tr><td>
			<?php if($imputation->getMethodOfPaymentId() != "3"):?>
				<?php echo __('Price')." : ".$imputation->getTotal().$defaultCurrency." (".__($imputation->getImputationMethodOfPayment()).")";?>
			<?php else:?>
				<?php echo __('Price')." : ".$imputation->getTotal().$defaultCurrency." (".$imputation->getAccount()->getAct().")";?>
			<?php endif;?>
		</td></tr>
	<?php endif;?>
	
	<?php if(isset($accountTransaction)):?>
		<?php if($accountTransaction['designation'] != null):?>
			<tr><td>
				<?php echo __('Transaction designation')." : ".$accountTransaction['designation']?>
			</td></tr>
		<?php endif;?>
		<?php if($accountTransaction['sum'] != null):?>
			<tr><td>
				<?php if($accountTransaction['sum'] >= 0):?>
					<?php echo __('Credited sum')." : ".$accountTransaction['sum']." ".$imputation->getAccount()->getAct()->getUnity()?>
				<?php else:?>
					<?php echo __('Debited sum')." : ".$accountTransaction['sum']." ".$imputation->getAccount()->getAct()->getUnity()?>
				<?php endif;?>
			</td></tr>
		<?php endif;?>
		
	<?php elseif(isset($purchase)):?>
		<tr><td>
			<?php echo __('Number of unities')." : ".$purchase['number_of_unities']?>
		</td></tr>
	
	<?php elseif(isset($countableService)):?>
		<tr><td>
			<?php echo __('Initial value')." : ".$countableService['initial_value']?>
		</td></tr>
	
	<?php elseif(isset($unitaryService)):?>
		<tr><td>
			<?php echo __('Number of unities')." : ".$unitaryService['number_of_unities']?>
		</td></tr>
		<tr><td>
			<?php echo __('Beginning time')." : ".date_format(new DateTime($unitaryService['beginning_time']),'H:i')?>
		</td></tr>
		<tr><td>
			<?php echo __('End time')." : ".date_format(new DateTime($unitaryService['end_time']),'H:i')?>
		</td></tr>
		<tr><td>
			<?php echo __('Computer')." : ".$computer?>
		</td></tr>

	<?php else:?>
		<tr><td>
			<?php echo __('End date')." : ".date_format(new DateTime($subscription['final_date']), __('m-d-Y'));?>
		</td></tr>
		
	<?php endif;?>
	
	<?php if($imputation->getBuildingId() != null):?>
		<tr><td>
			<?php echo __('Building')." : ".$imputation->getBuilding()?>
		</td></tr>
	<?php endif;?>
	
	<?php if($imputation->getRoomId() != null):?>
		<tr><td>
			<?php echo __('Room')." : ".$imputation->getRoom()?>
		</td></tr>
	<?php endif;?>
	
	<?php if($imputation->getComment() != ""):?>
		<tr><td>
			<?php echo __('Comment')." : ".$imputation->getComment()?>
		</td></tr>
	<?php endif;?>
</table>