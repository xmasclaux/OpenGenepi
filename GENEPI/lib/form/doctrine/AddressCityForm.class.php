<?php

/**
 * AddressCity form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AddressCityForm extends BaseAddressCityForm
{
  public function configure()
  {
  	$context = sfContext::getInstance();
    
  	$this->setWidget('address_country_id', new sfWidgetFormDoctrineChoice(array(
  		'model' => $this->getRelatedModelName('AddressCountry'), 
  		'add_empty' => true)
    ));
  	
     $this->widgetSchema['name']->setAttribute('readonly', 'readonly');
     $this->widgetSchema['postal_code']->setAttribute('readonly', 'readonly');
     
  	 $this->widgetSchema['newAddress'] = new sfWidgetFormInputText();
  	
  	 $this->useFields(array('address_country_id', 'newAddress', 'name', 'postal_code'));
  	
  	  if(isset($this['newAddress']))
      {     
	      $this->setWidget('newAddress', new sfWidgetFormJQueryAutocompleter(array(
	        'url'    =>  $context->getController()->genUrl('@address_getCities'),
	        'label'  => 'Enter a postal code or a city name',
	      	'config' => '{ extraParams: { country_id: function() { return jQuery("#form_address_address_country_id").val(); } },}'
	      )));
      }
    
    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'address_country_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCountry'), 'required' => false)),
      'newAddress'		   => new sfValidatorString(array('max_length' => 90, 'required' => false)),
    ));
    
    $this->widgetSchema->setLabel('address_country_id', 'Country *');
    $this->widgetSchema->setLabel('name', 'City *');
    $this->widgetSchema->setLabel('postal_code', 'Postal code');
    
    $this->setValidator('name', new sfValidatorString(
     	array('required' => true), 
     	array('required' => 'The city field is compulsory.')
  	));
    
  	$this->setValidator('postal_code', new sfValidatorString(
     	array('required' => false), 
     	array('required' => 'The postal code field is compulsory.')
  	));
    
  	$this->setValidator('address_country_id', new sfValidatorString(
     	array('required' => true), 
     	array('required' => 'The country field is compulsory.')
  	));
  	
  	$structure_address = Doctrine_Query::create()
			->select('a.address_city_id')
			->from('Address a')
			->innerJoin('a.Structure s')
			->fetchOne();

	$structure_address_city = Doctrine_Query::create()
			->select('ac.*')
			->from('AddressCity ac')
			->where('ac.id = ? ',$structure_address['address_city_id'])
			->fetchOne();
    
	if(!strcmp($context->getModuleName(),"struct"))
	{
	    $this->setDefault('address_city_id', $structure_address_city['id']);
		$this->setDefault('name', $structure_address_city['name']);
	    $this->setDefault('postal_code', $structure_address_city['postal_code']);
	    $this->setDefault('address_country_id', $structure_address_city['address_country_id']);
	}
  }
}
