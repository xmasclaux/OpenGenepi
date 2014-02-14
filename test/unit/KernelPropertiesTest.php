<?php 
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../apps/core/modules/kernel/lib/KernelProperties.class.php';
 
class KernelPropertiesTest extends KernelProperties {
	public static function getInstalledModules(){
		return parent::getInstalledModules();
	}
	
	public static function setInstalledModules($arg){
		parent::setInstalledModules($arg);
	}
	
	public static function setRelativePathToApps($path){
		parent::setRelativePathToApps($path);
	}
	

	public static function getRelativePathToApps(){
		return parent::getRelativePathToApps();
	}
	

	public static function setDependenciesTable($table){
		parent::setDependenciesTable($table);
	}
	

	public static function getDependenciesTable(){
		return parent::getDependenciesTable();
	}
	

	public static function addUnsatisfiedDependency($name){
		parent::addUnsatisfiedDependency($name);
	}
	

	public static function getUnsatisfiedDependencies(){
		return parent::getUnsatisfiedDependencies();
	}
}
$t = new lime_test(5);
$array_test = array('test1','test2');
$string_test = 'string_test';

/*F20202-T01*/
KernelPropertiesTest::setInstalledModules($array_test);
$t->is_deeply($array_test,KernelPropertiesTest::getInstalledModules(),'TEST OF: KernelProperties::setInstalledModules and KernelProperties::getInstalledModules methods.');

/*F20202-T02*/
KernelPropertiesTest::setRelativePathToApps($string_test);
$t->is_deeply($string_test,KernelPropertiesTest::getRelativePathToApps(),'TEST OF: KernelProperties::setRelativePathToApps and KernelProperties::getRelativePathToApps methods.');

/*F20202-T03*/
KernelPropertiesTest::setDependenciesTable($array_test);
$t->is_deeply($array_test,KernelPropertiesTest::getDependenciesTable(),'TEST OF: KernelProperties::setDependenciesTable and KernelProperties::getDependenciesTable methods.');

/*F20202-T04*/
KernelPropertiesTest::addUnsatisfiedDependency($array_test[0]);
KernelPropertiesTest::addUnsatisfiedDependency($array_test[1]);
$t->is_deeply($array_test,KernelPropertiesTest::getUnsatisfiedDependencies(),'TEST OF: KernelProperties::addUnsatisfiedDependency and KernelProperties::getUnsatisfiedDependencies methods.');

/*F20202-T05*/
KernelProperties::setError('error');
$t->is_deeply(array('error'),KernelProperties::getErrors(),'TEST OF: KernelProperties::setError and KernelProperties::getErrors methods.')

?>