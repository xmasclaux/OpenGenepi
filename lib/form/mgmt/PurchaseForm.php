<?php

/**
 * Purchase form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class PurchaseForm extends sfForm{
	
	public function setup(){
	
		/*----------------------------------WIDGETS----------------------------------------------*/
		
	  	$this->setWidgets(array(
	  		'designation' 			        => new sfWidgetFormInputText(),
	  		'shortened_designation' 	    => new sfWidgetFormInputText(),
	  		'comment' 						=> new sfWidgetFormTextarea(),
	  		'act_type_id'					=> new sfWidgetFormInputHidden(),
	    ));
	    
	    $this->widgetSchema->setLabels(array(
	    	'designation'                  => 'Act name',
	  		'shortened_designation'        => 'Shortened name',
	    ));
	    
	    $this->widgetSchema->setDefaults(array(
	    	'act_type_id'                  => '4',
	    ));
	    
	    /*-----------------------------------VALIDATORS-------------------------------------------*/
	    
	   	$this->setValidator('designation', new sfValidatorString(
     	array('max_length' => 45, 'required' => true), 
     	array('max_length' => 'The name field must not exceed %max_length% characters.',
     		  'required' => 'The name field is compulsory.')
  		));
  	
  		$this->setValidator('shortened_designation', new sfValidatorString(
     	array('max_length' => 20, 'required' => true), 
     	array('max_length' => 'The shortened name field must not exceed %max_length% characters.',
     		  'required' => 'The shortened name field is compulsory.')
  		));
  	
  		$this->setValidator('comment', new sfValidatorString(
     	array('max_length' => 250, 'required' => false), 
     	array('max_length' => 'The comment field must not exceed %max_length% characters.')
  		));
	
  		$this->setValidator('act_type_id', new sfValidatorString(
     	array('required' => true)
  		));
  		
	    /*-------------------------------WIDGETS ATTRIBUTES--------------------------------------*/
	    
	    $this->widgetSchema->setNameFormat('%s');
	    
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	
	}
	
}