<?php 
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../apps/core/modules/kernel/lib/Kernel.class.php';
require_once dirname(__FILE__).'/../../apps/core/modules/kernel/lib/Module.class.php';

class KernelTest extends Kernel{
	public static function askForDependencies($app_path, $module_path, $module_name){
		return parent::askForDependencies($app_path,$module_path,$module_name);
	}
}

$t = new lime_test(51);

/*--------------------------------------------F20202--------------------------------------------------------*/

/*F20202-T06*/
Kernel::initialize(dirname(__FILE__).'/../../apps/');
$t->isnt(Kernel::getInstalledModules(),null,'TEST OF: Kernel::initialize method.');





/*---------------------------------------------F20201-------------------------------------------------------*/

/*F20201-T01*/
$tab_test = KernelTest::askForDependencies('core/','modules/kernel/','kernel');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the kernel module');

$tab_test = KernelTest::askForDependencies('core/','modules/dbi/','dbi');
$t->isnt($tab_test,null,'TEST OF: Kernel::askForDependencies method for the dbi module');

$tab_test = KernelTest::askForDependencies('core/','modules/ihm/','ihm');
$t->isnt($tab_test,null,'TEST OF: Kernel::askForDependencies method for the ihm module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/act/','act');
$t->isnt($tab_test,null,'TEST OF: Kernel::askForDependencies method for the act module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/moderator/','moderator');
$t->isnt($tab_test,null,'TEST OF: Kernel::askForDependencies method for the moderator module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/user/','user');
$t->isnt($tab_test,null,'TEST OF: Kernel::askForDependencies method for the user module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/struct/','struct');
$t->isnt($tab_test,null,'TEST OF: Kernel::askForDependencies method for the struct module');



/*F20201-T02*/
$tab_test = KernelTest::askForDependencies('co_re/','modules/kernel/','kernel');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the kernel module');

$tab_test = KernelTest::askForDependencies('core /','modules/dbi/','dbi');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the dbi module');

$tab_test = KernelTest::askForDependencies('_core/','modules/ihm/','ihm');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the ihm module');

$tab_test = KernelTest::askForDependencies('mGmt/','modules/act/','act');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the act module');

$tab_test = KernelTest::askForDependencies('MGMT/','modules/moderator/','moderator');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the moderator module');

$tab_test = KernelTest::askForDependencies('m  gmt/','modules/user/','user');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the user module');

$tab_test = KernelTest::askForDependencies('mmt/','modules/struct/','struct');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the struct module');




/*F20201-T03*/
$tab_test = KernelTest::askForDependencies('core/','modules /kernel/','kernel');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the kernel module');

$tab_test = KernelTest::askForDependencies('core/','modules_/dbi/','dbi');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the dbi module');

$tab_test = KernelTest::askForDependencies('core/','modules/ihm_/','ihm');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the ihm module');

$tab_test = KernelTest::askForDependencies('mgmt/','mod   ules/act/','act');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the act module');

$tab_test = KernelTest::askForDependencies('mgmt/','___modules/moderator/','moderator');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the moderator module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/user/__','user');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the user module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/Struct/','struct');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the struct module');




/*F20201-T04*/
$tab_test = KernelTest::askForDependencies('core/','modules/kernel/','ke_rnel');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the kernel module');

$tab_test = KernelTest::askForDependencies('core/','modules/dbi/','DBI');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the dbi module');

$tab_test = KernelTest::askForDependencies('core/','modules/ihm/','ihm  ');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the ihm module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/act/','--act');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the act module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/moderator/','modera()tor');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the moderator module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/user/','use56r');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the user module');

$tab_test = KernelTest::askForDependencies('mgmt/','modules/struct/','struct  _8');
$t->is($tab_test,null,'TEST OF: Kernel::askForDependencies method for the struct module');










/*-------------------------------------------F20501---------------------------------------------------------*/

/*F20501-T02*/
Kernel::initialize('');
$t->is(Kernel::getInstalledModules(),null,'TEST OF: Kernel::initialize method with wrong path.');
$t->isnt(Kernel::getErrors(),null,'TEST OF: Getting errors after Kernel::initialize method with wrong path.');











/*--------------------------------------------F20503--------------------------------------------------------*/

/*F20503-T01*/
Kernel::buildInstalledModules();
$t->isnt(Kernel::getErrors(),null,'TEST OF: Instanciating modules without initializing kernel and dependencies table.');


/*F20503-T02*/
Kernel::initialize(dirname(__FILE__).'/../../apps/');
$modules = Kernel::buildInstalledModules();
$t->is(Kernel::getErrors(),null,'TEST OF: Instanciating modules with initializing kernel but without initializing dependencies table.');
$t->is($modules,false,'TEST OF: Instanciating modules with initializing kernel but without initializing dependencies table.');


/*F20503-T03*/
Kernel::initialize(dirname(__FILE__).'/../../apps/');
Kernel::buildDependenciesTable();
$modules = Kernel::buildInstalledModules();
$t->is(Kernel::getErrors(),null,'TEST OF: Instanciating modules with initializing kernel and dependencies table.');
$t->isnt($modules,array(),'TEST OF: Instanciating modules with initializing kernel and dependencies table.');











/*---------------------------------------------F20504-------------------------------------------------------*/

/*F20504-T01*/
$configuration = ProjectConfiguration::getApplicationConfiguration('core', '', true);
$cultures = Kernel::getInstalledCultures($configuration);
$t->is($cultures,null,'TEST OF: Getting installed cultures without any application configuration.');


/*F20504-T02*/
$configuration = ProjectConfiguration::getApplicationConfiguration('core', 'dev', true);
$cultures = Kernel::getInstalledCultures($configuration);
$t->is_deeply($cultures,array(),'TEST OF: Getting installed cultures with wrong application configuration.');

/*F20504-T03*/
$configuration = ProjectConfiguration::getApplicationConfiguration('mgmt', 'dev', true);
$cultures = Kernel::getInstalledCultures($configuration);
$t->isnt($cultures,null,'TEST OF: Getting installed cultures with correct application configuration.');
$t->isnt($cultures,array(),'TEST OF: Getting installed cultures with correct application configuration.');







/*-------------------------------------------------F20505---------------------------------------------------*/

/*F20505-T01*/
Kernel::flushAll();
$tab_test = Kernel::check();
$t->isnt($tab_test,null,'TEST OF: Kernel::check() method without initializing.');

/*F20505-T02*/
Kernel::flushAll();
Kernel::initialize(dirname(__FILE__).'/../../apps/');
$tab_test = Kernel::check();
$t->isnt($tab_test,null,'TEST OF: Kernel::check() method without initializing.');

/*F20505-T03*/
Kernel::flushAll();
Kernel::initialize(dirname(__FILE__).'/../../apps/');
Kernel::buildDependenciesTable();
$tab_test = Kernel::check();
$t->is($tab_test,null,'TEST OF: Kernel::check() method without initializing.');





/*-------------------------------------------------F20506---------------------------------------------------*/
/*F20506-T01*/
Kernel::flushAll();
$instance = Kernel::createInstance();
$t->is($instance->getInstalledModules(),null,'TEST OF: Kernel::createInstance without initializing and building dependencies.');
$t->is($instance->getDependenciesTable(),null,'TEST OF: Kernel::createInstance without initializing and building dependencies.');

/*F20506-T02*/
Kernel::flushAll();
Kernel::initialize(dirname(__FILE__).'/../../apps/');
$instance = Kernel::createInstance();
$t->isnt($instance->getInstalledModules(),null,'TEST OF: Kernel::createInstance with initializing but without building dependencies.');
$t->is($instance->getDependenciesTable(),null,'TEST OF: Kernel::createInstance with initializing but without building dependencies.');

/*F20506-T03*/
Kernel::flushAll();
Kernel::buildDependenciesTable();
$instance = Kernel::createInstance();
$t->is($instance->getInstalledModules(),null,'TEST OF: Kernel::createInstance without initializing but with building dependencies.');
$t->is($instance->getDependenciesTable(),null,'TEST OF: Kernel::createInstance without initializing but with building dependencies.');

/*F20506-T04*/
Kernel::flushAll();
Kernel::initialize(dirname(__FILE__).'/../../apps/');
Kernel::buildDependenciesTable();
$instance = Kernel::createInstance();
$t->isnt($instance->getInstalledModules(),null,'TEST OF: Kernel::createInstance without initializing but with building dependencies.');
$t->isnt($instance->getDependenciesTable(),null,'TEST OF: Kernel::createInstance without initializing but with building dependencies.');
?>