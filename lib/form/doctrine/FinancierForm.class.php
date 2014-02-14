<?php

/**
 * Financier form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FinancierForm extends BaseFinancierForm
{
  public function configure()
  {
  	$this->widgetSchema['logo_path'] = new sfWidgetFormInputFile(array(
                                        'label' => 'Chemin du logo'));
 
    $this->validatorSchema['logo_path'] = new sfValidatorFile(array(
                                        'required' => false,
                                        'path' => sfConfig::get('sf_upload_dir').'/images',
                                        'mime_types' => 'web_images',
                               ), array(
   										'mime_types' 	=> 'Invalid picture format.')
                               );
                               
    $this->widgetSchema['comment'] = new sfWidgetFormTextarea();
    
    $this->widgetSchema->setLabel('name', 'Financier name');
    
    $this->setValidator('name', new sfValidatorString(
  		array('max_length' => 45), 
  		array('required'   => 'The name field is compulsory.', 
  			  'max_length' => 'The name field must not exceed %max_length% characters.')
  	));
  	
  	$this->setValidator('comment', new sfValidatorString(
     	array('max_length' => 250, 'required' => false), 
     	array('max_length' => 'The comment field must not exceed %max_length% characters.')
  	));
  }
}
