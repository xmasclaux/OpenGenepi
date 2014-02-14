<?php echo utf8_decode(__('Log export'). ' - '.date('d/m/y G:i:s'))."\n" ?>
<?php echo "----------------------------------------------\n\n" ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Server'))."\n" ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Signature').' : '.getenv("SERVER_SOFTWARE"))."\n" ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Database'))."\n" ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('DBMS')).' :'?>
<?php if($dbvalues['dbms'] == 1) : ?> <?php echo "MySQL\n"?>
<?php else : ?> <?php echo "PostgreSQL\n"?>
<?php endif; ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Client'))."\n" ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Browser').' : '.getenv("HTTP_USER_AGENT"))."\n"?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Plugins'))."\n" ?>
<?php echo "----------------------------------------------\n" ?>
<?php echo utf8_decode(__('Dependencies')).":\n"?>
<?php echo utf8_decode(__('Module Name')." :\n"." ".__('Dependencies')." - ".__('State'))."\n"?>
<?php foreach ($Kernel->getDependenciesTable() as $module => $dependencies):?>
<?php echo utf8_decode($module)?><?php echo " :\n"?>
<?php foreach ($dependencies as $dependency):?>
<?php echo " " ?><?php echo utf8_decode($dependency)?><?php echo " - "?>
<?php if( Module::isActivated($Modules, $dependency)):?>
<?php echo utf8_decode(__('Dependency satisfied'))."\n"?>
<?php else:?>
<?php echo utf8_decode(__('Dependency not satisfied'))."\n"?>
<?php endif;?>
<?php endforeach;?>
<?php echo "\n"?>
<?php endforeach; ?>

<?php echo utf8_decode(__('Activated modules')).":\n"?>
<?php echo utf8_decode(__('Module Name')." - ".__('Is Compulsory'). " - ".__('Menu Entry Name'))."\n"?>
<?php foreach ($Modules as $module):?>
<?php echo utf8_decode($module->getModuleName())?><?php echo (" - ")?>
<?php if($module->isCompulsory()){
echo utf8_decode(__('yes'));
}else{ echo utf8_decode(__('no'));
}?>
<?php if ($module->getMenuEntryName() != null) : ?><?php echo (" - ")?><?php endif;?>
<?php echo utf8_decode(__($module->getMenuEntryName()))."\n"?>
<?php endforeach; ?>		
<?php 
	$filename = "export_".date("d/m/y")."_".date("G:i:s").".txt";
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