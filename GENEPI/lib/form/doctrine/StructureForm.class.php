<?php

/**
 * Structure form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StructureForm extends BaseStructureForm
{
  public function configure()
  {
  	//We hide the address_id. It will be filled in JavaScript.
  	$this->widgetSchema['address_id'] = new sfWidgetFormInputHidden();
  	
  	$this->widgetSchema['logo_path'] = new sfWidgetFormInputFile(array('label' => 'Logo path'));
 
    $this->validatorSchema['logo_path'] = new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/images',
                                        'mime_types' => 'web_images',
                               ), array(
   										'mime_types' 	=> 'Invalid picture format.')
                               );

    $this->setValidator('name', new sfValidatorString(
     	array('max_length' => 45, 'required' => true), 
     	array('max_length' => 'The name field must not exceed %max_length% characters.',
     		  'required' => 'The name field is compulsory.')
  	));
  	
    $this->setValidator('email', new sfValidatorEmail(
   		array('required' => false), 
   		array('invalid'  => 'This email address is invalid.') 
  	));
  	
  	$this->setValidator('website', new sfValidatorString(
     	array('max_length' => 250, 'required' => false), 
     	array('max_length' => 'The website field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('telephone_number', new sfValidatorString(
     	array('max_length' => 20, 'required' => false), 
     	array('max_length' => 'The telephone number field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('siret_number', new sfValidatorString(
     	array('max_length' => 20, 'required' => false), 
     	array('max_length' => 'The siret number field must not exceed %max_length% characters.')
  	));
  	
  	$this->widgetSchema->setLabel('siret_number', 'SIRET/INSEE number');
  	$this->widgetSchema->setLabel('name', 'Structure name');
  	
  	$this->widgetSchema->setLabel('telephone_number', 'Telephone number n°2');
  	
  	$this->widgetSchema->setNameFormat('form[%s]');
  	
  	if(!$this->getOption('firstBoot'))
  	{
  		$subFormAddress = new AddressForm($this->getObject()->getAddress());
  		$this->embedForm('address', $subFormAddress);
  	}
  	
  }
}