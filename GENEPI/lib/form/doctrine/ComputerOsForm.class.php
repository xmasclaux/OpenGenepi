<?php

/**
 * ComputerOs form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ComputerOsForm extends BaseComputerOsForm
{
  public function configure()
  {
  	$this->useFields(array('computer_os_family_id', 'id'));
  	
  	$families = array(0 => '');
    $families_query = Doctrine_Query::create()
		      	->select('c.family')
		    	->from('ComputerOsFamily c')
		    	->orderBy('c.sort_order');
	$families_res = $families_query->fetchArray();
	foreach($families_res as $family){
		  $families[$family['id']] = $family['family'];
	}
  	
	$this->widgetSchema['computer_os_family_id'] = new sfWidgetFormSelect(array('choices' => $families));
	
	$this->setValidator('computer_os_family_id', new sfValidatorString(
     	array('max_length' => 45, 'required' => false), 
     	array('max_length' => 'The operating system field must not exceed %max_length% characters.',
     		  'invalid' => 'Invalid operating system.')
  	));
	
  	$this->widgetSchema->setLabel('computer_os_family_id', 'Family');
  }
}
