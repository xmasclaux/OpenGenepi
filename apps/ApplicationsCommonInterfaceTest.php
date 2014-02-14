<?php
require_once('ApplicationsCommonInterface.class.php');

$instance = new ApplicationsCommonInterface('./');
//$instance->addModule('planning','modules/planning');

$ret = $instance->removeModule('planning');
echo($ret);
?>