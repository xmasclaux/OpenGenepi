<?php

/**
 * Address form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AddressForm extends BaseAddressForm
{
  public function configure()
  {
  	$this->useFields(array('id', 'address_city_id', 'telephone_number', 'street'));
  	
  	$this->widgetSchema['address_city_id'] = new sfWidgetFormInputHidden();
  	
  	if ($this->getObject()->getAddressCityId() == null) {
  		$this->setDefault('address_city_id',"1");
  	}
  	
  	$this->widgetSchema->setLabel('street', 'Street, place, avenue');
  	
  	$this->setValidator('telephone_number', new sfValidatorString(
     	array('max_length' => 20, 'required' => false), 
     	array('max_length' => 'The telephone number field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('street', new sfValidatorString(
     	array('max_length' => 80, 'required' => false), 
     	array('max_length' => 'The street, place, avenue field must not exceed %max_length% characters.')
  	));
	
  	//Subform AddressCity
  	$subFormAddressCity = new AddressCityForm($this->getObject()->getAddressCity());
  	$this->mergeForm($subFormAddressCity);
  }
}
