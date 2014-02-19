<?php echo utf8_decode(__('Email addresses export'). ' - '.date('d/m/y G:i:s'))."\n" ?>

<?php echo $numberEmails." ".__('email addresses exported')."."."\n\n"?>
<?php foreach($users as $user):?>
<?php echo $user->getName()." ".$user->getSurname()." <".$user->getEmail().">; "?>
<?php endforeach;?>
	
<?php 
	$filename = "email_".date("d/m/y")."_".date("G:i:s").".txt";
	$filesize = sizeof($filename);
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Cache-Control: no-cache, must-revalidate");
	header("Content-Type: text/html; charset=UTF-8");
	header("Content-Type: application/force-download; name=\"".$filename."\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " .$filesize );
	header("Content-Disposition: attachment; filename=\"".$filename."\"");
?>