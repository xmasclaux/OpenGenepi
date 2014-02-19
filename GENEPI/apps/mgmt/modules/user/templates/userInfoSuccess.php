<script type="text/javascript">
	  $(document).ready(function() {
		  $('#userInfo, #userAccount').each(function() {
			  	$('tr:odd td', this).css({'background' : '#f2f2f2'});
			});

		  $('#userSubscription').each(function() {
			  	$('tr:odd td', this).css({'background' : '#f2f2f2'});
			});
		  $("#dialog #back-button").click ( function() { $("#dialog").dialog("close");  } );
		  $("#dialog #alter-button").click ( function() { 
			  $("#dialog").dialog("close");
		  } );
	  });
</script>

<p style="font-weight: bold";>
	<?php echo $user->getName()." ".$user->getSurname();?>
</p>

<form action="<?php echo url_for('use/index') ?>" method="post">
	<input name = "user_id" type="hidden" value="<?php echo $user->getId() ?>"></input>
	
	<table class="largeTable" id="userInfo">
		<?php if($user->getOrganizationName() != null):?>
		<tr><td>
			<?php echo __('Organization')." : ".$user->getOrganizationName()?>
		</td></tr>
		<?php endif;?>
		
		<tr><td><?php echo __('Born on')." ".date_format(new DateTime($user->getBirthdate()), __('m-d-Y'))?></tr>
		
		<?php if($user->getEmail() != null):?>
		<tr><td>
			<?php echo __('Email')." : ".$user->getEmail()?>
		</td></tr>
		<?php endif;?>
		
		<?php if($user->getAddressId() != null):?>
			<?php if($user->getAddress()->getTelephoneNumber() != null):?>
			<tr><td>
				<?php echo __('Telephone')." : ".$user->getAddress()->getTelephoneNumber()?>
			</td></tr>
			<?php endif;?>
		<?php endif;?>
		
		<?php if($user->getCellphoneNumber() != null):?>
		<tr><td>
			<?php echo __('Cellphone')." : ".$user->getCellphoneNumber() ?>
		</td></tr>
		<?php endif;?>
		
		<?php if($user->getUserGenderId() != null):?>
		<tr><td>
			<?php echo __('Gender')." : ".$user->getUserGender() ?>
		</td></tr>
		<?php endif;?>
		
		<?php if($user->getUserSegId() != null):?>
		<tr><td>
			<?php echo __('SEG')." : ".$user->getUserSeg() ?>
		</td></tr>
		<?php endif;?>
		
		<?php if($user->getUserAwarenessId() != null):?>
		<tr><td>
			<?php echo __('Awareness')." : ".$user->getUserAwareness() ?>
		</td></tr>
		<?php endif;?>
		
		<?php if($user->getActPublicCategoryId() != null):?>
		<tr><td>
			<?php echo __('Category')." : ".$user->getActPublicCategory() ?>
		</td></tr>
		<?php endif;?>
		
		<?php if($user->getAddressId() != null):?>
			<?php if(($user->getAddress()->getStreet() != null) || ($user->getAddress()->getAddressCityId() != 1)): ?>
			<tr><td>
				<?php echo __('Address')." : "?>
				<?php if($user->getAddress()->getStreet() != null):?>
					<?php echo $user->getAddress()->getStreet()." " ?>
				<?php endif;?>
				<?php if($user->getAddress()->getAddressCityId() != null):?>
					<?php echo $user->getAddress()->getAddressCity()->getPostalCode()." " ?>
					<?php echo $user->getAddress()->getAddressCity()->getName()." " ?>
					<?php if($user->getAddress()->getAddressCity()->getAddressCountryId() != null):?>
						<?php echo __($user->getAddress()->getAddressCity()->getAddressCountry()->getName()) ?>
					<?php endif;?>
				<?php endif;?>
			</td></tr>
			<?php endif;?>
		<?php endif;?>
		
		<?php if($user->getComment() != null):?>
		<tr><td>
			<?php echo __('Comment')." : ".$user->getComment() ?>
		</td></tr>
		<?php endif;?>
	
	</table>
	
	<?php if (sizeof($userAccounts)!=0):?>
		<p style="font-weight: bold";>
			<?php echo __('Accounts list') ?>
		</p>
		<table class="largeTable" id="userAccount">
			<?php foreach ($userAccounts as $userAccount):?>
				<tr><td>
					<?php echo $userAccount->getAccount()->getAct()." : ";?>
					
					<?php if($userAccount->getAccount()->getValue()>=10): ?>
						<?php echo $userAccount->getAccount()->getValue();?>
						<?php echo $userAccount->getAccount()->getAct()->getUnity()->getShortenedDesignation();?>
						<?php echo " ".__('left')."."?>
					<?php elseif($userAccount->getAccount()->getValue()<=10 && $userAccount->getAccount()->getValue()>0): ?>
						<span style="color:#4261d1;">
							<?php echo $userAccount->getAccount()->getValue();?>
							<?php echo $userAccount->getAccount()->getAct()->getUnity()->getShortenedDesignation();?>
							<?php echo " ".__('left')."."?>
						</span>
					<?php elseif($userAccount->getAccount()->getValue()==0): ?>
						<span style="color:#b00000;">
							<?php echo __('Totality of the account consumed')."."?>
						</span>
					<?php else :?>
						<span style="color:#ff3333;">
							<?php echo __('Negative account')." : "?>
							<?php echo $userAccount->getAccount()->getValue();?>
							<?php echo $userAccount->getAccount()->getAct()->getUnity()->getShortenedDesignation().".";?>
						</span>
					<?php endif;?>
					
					
				</td></tr>
			<?php endforeach;?>
		</table>
	<?php endif;?>
	
	<?php if ($subscription):?>
		<p style="font-weight: bold";>
			<?php echo __('Subscriptions list') ?>
		</p>
		<table class="largeTable" id="userSubscription">
			<?php foreach ($userSubscriptions as $userSubscription):?>
			<tr><td>
				<?php if(isset($finalDate[$userSubscription->getId()])):?>
					<?php echo $userSubscription->getAct().", ".__('expires on');?>
					<?php echo date_format(new DateTime($finalDate[$userSubscription->getId()]), __('m-d-Y'))."."?>
					<?php if(isset($daysLeft[$userSubscription->getId()])): ?>
						<div style="color:#4261d1;"><?php echo __('Caution').", ".__('this subscription will be outdated in')." ".$daysLeft[$userSubscription->getId()]." ".__('day(s)')."."?></div>
					<?php elseif(isset($noDaysLeft[$userSubscription->getId()])):?>
						<div style="color:#b00000;"><?php echo __("Subscription finished today")."." ?></div>
					<?php elseif(isset($daysLate[$userSubscription->getId()])):?>
						<div style="color:#ff3333;"><?php echo __('Caution').", ".__('subscription outdated since')." ".$daysLate[$userSubscription->getId()]." ".__('day(s)')."."?></div>
					<?php endif;?>
				<?php endif;?>
				</td></tr>
			<?php endforeach;?>
		</table>
	<?php endif;?>

	<?php if($okOnly !=1):?>
		<div class="rightAlignement">
		   <input type="button" value="<?php echo __('Ok') ?>" id="back-button" />
		</div>
		<div class="rightAlignement">
		   <input type="submit" value="<?php echo __('Impute an act') ?>" />
		</div>
		<div class="rightAlignement">
		   <input type="button" value="<?php echo __('Alter') ?>" id='alter-button' onClick="document.location.href='<?php echo url_for('user/edit').'?id='.$user->getId()?>';"/>
		</div>
	<?php endif;?>
</form>