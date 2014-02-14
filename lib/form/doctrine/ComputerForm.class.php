<?php

/**
 * Computer form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ComputerForm extends BaseComputerForm
{
  public function configure()
  {
  	
    $operatingSystems_query = Doctrine_Query::create()
		      	->select('c.designation')
		    	->from('ComputerOs c')
		    	->orderBy('c.sort_order');
	$operatingSystems_res = $operatingSystems_query->fetchArray();
	foreach($operatingSystems_res as $operatingSystem){
		  $operatingSystems[$operatingSystem['id']] = $operatingSystem['designation'];
	}
  	
  	$this->widgetSchema['computer_type_of_connexion_id'] = new sfWidgetFormDoctrineChoice(array(
  		'model' => $this->getRelatedModelName('ComputerTypeOfConnexion'), 
  		'add_empty' => true));
  	
  	$this->widgetSchema['computer_os_id'] = new sfWidgetFormSelect(array('choices' => $operatingSystems));
  	
  	$this->setValidator('name', new sfValidatorString(
     	array('max_length' => 45, 'required' => true), 
     	array('max_length' => 'The name field must not exceed %max_length% characters.',
     		  'required' => 'The name field is compulsory.')
  	));
  	
  	$this->setValidator('shortened_name', new sfValidatorString(
     	array('max_length' => 20, 'required' => true), 
     	array('max_length' => 'The shortened name field must not exceed %max_length% characters.',
     		  'required' => 'The shortened name field is compulsory.')
  	));
  	
  	$this->setValidator('comment', new sfValidatorString(
     	array('max_length' => 250, 'required' => false), 
     	array('max_length' => 'The comment field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('computer_type_of_connexion_id', new sfValidatorString(
     	array('max_length' => 45, 'required' => true), 
     	array('max_length' => 'The type of connection field must not exceed %max_length% characters.',
     		  'required' => 'The type of connection field is compulsory.')
  	));
  	
  	$this->setValidator('computer_os_id', new sfValidatorString(
     	array('max_length' => 45, 'required' => false), 
     	array('max_length' => 'The operating system field must not exceed %max_length% characters.',
     		  'invalid' => 'Invalid operating system.')
  	));
  	
  	$this->setValidator('year', new sfValidatorInteger(
     	array('required' => false), 
     	array('invalid' => '"%value%" is not a year.')
  	));
  	
  	$this->setValidator('ip_address', new sfValidatorString(
     	array('max_length' => 45, 'required' => false), 
     	array('max_length' => 'The IP address field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('mac_address', new sfValidatorString(
     	array('max_length' => 45, 'required' => false), 
     	array('max_length' => 'The MAC address field must not exceed %max_length% characters.')
  	));
  	
  	$this->widgetSchema['comment'] = new sfWidgetFormTextarea();
  	
  	$this->widgetSchema->setLabel('name', 'Computer name');
  	$this->widgetSchema->setLabel('mac_address', 'MAC Address');
  	$this->widgetSchema->setLabel('ip_address', 'IP Address');
  	$this->widgetSchema->setLabel('computer_machine_type_id', 'Machine Type');
  	$this->widgetSchema->setLabel('computer_type_of_connexion_id', 'Type of connection');
  	$this->widgetSchema->setLabel('computer_os_id', 'Operating System');
  	
  	$subFormComputerOs = new ComputerOsForm($this->getObject()->getComputerOs());
  	$this->mergeForm($subFormComputerOs);
  }
}
