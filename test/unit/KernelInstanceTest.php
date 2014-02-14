<?php 
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../apps/core/modules/kernel/lib/KernelInstance.class.php';
require_once dirname(__FILE__).'/../../apps/core/modules/kernel/lib/KernelProperties.class.php';


$t = new lime_test(35);
$instance = new KernelInstance(null,null);
/*-----------------------------------------------------------F20601-----------------------------------------------------------*/

//F20601-T01:
$instance->addLog('info','test_info_1');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), true, 'TEST OF: KernelInstance::addLog method');
unlink(ProjectConfiguration::guessRootDir().'/log/info.log');

//F20601-T02:
$instance->addLog('','test_info_1');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLog method');

//F20601-T03:
$instance->addLog(null,'test_info_1');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLog method');

//F20601-T04:
$instance->addLog('info','');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLog method');

//F20601-T05:
$instance->addLog('info',null);
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLog method');



/*-----------------------------------------------------------F20602-----------------------------------------------------------*/
//F20602-T01:
$array = array('info' => 'test_info', 'info' => 'test_info2', 'info' => 'test_info3');
$instance->addMultipleLog($array);

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), true, 'TEST OF: KernelInstance::addLog method');
unlink(ProjectConfiguration::guessRootDir().'/log/info.log');


//F20602-T02:
$array = array('info' => 'test_info', 'error' => 'test_error', 'warning' => 'test_warning');
$instance->addMultipleLog($array);

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), true, 'TEST OF: KernelInstance::addLog method');
unlink(ProjectConfiguration::guessRootDir().'/log/info.log');

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), true, 'TEST OF: KernelInstance::addLog method');
unlink(ProjectConfiguration::guessRootDir().'/log/error.log');

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/warning.log'), true, 'TEST OF: KernelInstance::addLog method');
unlink(ProjectConfiguration::guessRootDir().'/log/warning.log');


//F20602-T03:
$instance->addMultipleLog(null);

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLog method');

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLog method');

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/warning.log'), false, 'TEST OF: KernelInstance::addLog method');

//F20602-T04:
$array = array();
$instance->addMultipleLog($array);

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLog method');

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLog method');

$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/warning.log'), false, 'TEST OF: KernelInstance::addLog method');

/*-----------------------------------------------------------F20603-----------------------------------------------------------*/

//F20603-T01
$instance->addLogIf(true,array('error' => 'test_error_2', 'info' => 'test_info_2'));
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), true, 'TEST OF: KernelInstance::addLogIf method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogIf method');
unlink(ProjectConfiguration::guessRootDir().'/log/error.log');

//F20603-T02
$instance->addLogIf(false,array('error' => 'test_error_2', 'info' => 'test_info_2'));
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogIf method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), true, 'TEST OF: KernelInstance::addLogIf method');
unlink(ProjectConfiguration::guessRootDir().'/log/info.log');

//F20603-T03
$instance->addLogIf(null,array('error' => 'test_error_2', 'info' => 'test_info_2'));
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogIf method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), true, 'TEST OF: KernelInstance::addLogIf method');
unlink(ProjectConfiguration::guessRootDir().'/log/info.log');

//F20603-T04
$instance->addLogIf(true,null);
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogIf method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogIf method');

//F20603-T04
$instance->addLogIf(false,array());
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogIf method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogIf method');


/*-----------------------------------------------------------F20604-----------------------------------------------------------*/

//F20604-T01
$instance->addLogChoice(1,array('info' => 'test_info','error' => 'test_error'));
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), true, 'TEST OF: KernelInstance::addLogChoice method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogChoice method');
unlink(ProjectConfiguration::guessRootDir().'/log/error.log');

//F20604-T02
$instance->addLogChoice(3,array('info' => 'test_info','error' => 'test_error'));
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogChoice method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogChoice method');

//F20604-T03
$instance->addLogChoice(-1,array('info' => 'test_info','error' => 'test_error'));
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogChoice method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogChoice method');

//F20604-T04
$instance->addLogChoice(2,array());
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogChoice method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogChoice method');

//F20604-T05
$instance->addLogChoice(2,null);
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/error.log'), false, 'TEST OF: KernelInstance::addLogChoice method');
$t->is(file_exists(ProjectConfiguration::guessRootDir().'/log/info.log'), false, 'TEST OF: KernelInstance::addLogChoice method')
?>