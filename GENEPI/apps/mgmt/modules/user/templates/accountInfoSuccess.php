<p><?php echo __('This account belongs to')." : "?></p>

<ul>
	<?php foreach($accountUsers as $accountUser):?>
		<li><p><?php echo $accountUser->getUser()->getName()." ".$accountUser->getUser()->getSurname();?></p></li>
	<?php endforeach;?>
</ul>