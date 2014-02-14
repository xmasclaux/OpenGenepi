<?php

/**
 * Building form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BuildingForm extends BaseBuildingForm
{
  public function configure()
  {
  	$this->widgetSchema['address_id'] = new sfWidgetFormInputHidden();
	
	$structure_address = Doctrine_Query::create()
			->select('a.*')
			->from('Address a')
			->innerJoin('a.Structure s')
			->fetchOne();
			
  	$this->setDefault('address_id', $structure_address['id']);
  	
  	$this->widgetSchema['same_address'] = new sfWidgetFormInputCheckbox(
  											array('label' => 'Same address than the structure'),
  											array('checked' => 'checked'));
  	
  	$this->setValidator('designation', new sfValidatorString(
     	array('max_length' => 45), 
     	array('max_length' => 'The name field must not exceed %max_length% characters.',
     		  'required' => 'The name field is compulsory.')
  	));
  	
  	$this->setValidator('shortened_designation', new sfValidatorString(
     	array('max_length' => 20, 'required' => true), 
     	array('max_length' => 'The shortened name field must not exceed %max_length% characters.',
     		  'required' => 'The shortened name field is compulsory.')
  	));
  	
  	$this->validatorSchema['same_address'] = new sfValidatorBoolean(); 
  	
  	$this->widgetSchema->setNameFormat('form[%s]');
  	
  	$this->widgetSchema->setLabel('designation', 'Building name');
  	$this->widgetSchema->setLabel('shortened_designation', 'Shortened name');
  	
  	$subFormAddress = new AddressForm($this->getObject()->getAddress());
  	$this->embedForm('address', $subFormAddress);
  	
  	$subFormAddress->setDefault('street', $structure_address['street']);
  	$subFormAddress->setDefault('telephone_number', $structure_address['telephone_number']);
  }
}
