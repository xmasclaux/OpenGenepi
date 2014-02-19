<?php

/**
 * Subscription form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class SubscriptionForm extends sfForm{
	
	public function setup(){
	
		$durationUnities = array(
			'0'		=> '',
			'1' 	=> 'minute(s)', 
			'2' 	=> 'hour(s)',
			'3' 	=> 'day(s)',
			'4'		=> 'month(s)',
			'5'		=> 'year(s)'
		);
		
		/*----------------------------------WIDGETS----------------------------------------------*/
		
	  	$this->setWidgets(array(
	  		'designation' 			        => new sfWidgetFormInputText(),
	  		'shortened_designation' 	    => new sfWidgetFormInputText(),
	  		'comment' 						=> new sfWidgetFormTextarea(),
	  		'duration' 						=> new sfWidgetFormInputHidden(),
	  		'duration_temp'					=> new sfWidgetFormInputText(),
	  		'duration_unity'              	=> new sfWidgetFormSelect(array('choices' => $durationUnities)),
	  		'max_members' 					=> new sfWidgetFormInputText(),
	  		'extra_cost'					=> new sfWidgetFormInputText(),
	  		'act_type_id'					=> new sfWidgetFormInputHidden(),
	    ));
	    
	    $this->widgetSchema->setLabels(array(
	    	'designation'                  => 'Act name',
	  		'shortened_designation'        => 'Shortened name',
	    	'max_members'				   => 'Max. number of members',
	    	'duration'					   => 'Period of validity',
	    	'extra_cost'				   => 'Extra cost per member'
	    ));
	    
	    $this->widgetSchema->setDefaults(array(
	    	'act_type_id'                  => '1',
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
  		
  		$this->setValidator('duration', new sfValidatorString(
     	array('required' => false)
  		));
  		
  		$this->setValidator('duration_unity', new sfValidatorString(
     	array('required' => false)
  		));
  		
  		$this->setValidator('duration_temp', new sfValidatorNumber(
  		array('required' => false, 'min' => 0),
  		array('min' => 'The duration must be positive.',
  			  'invalid' => 'The duration must be a number.')
  		));
  		
  		$this->setValidator('max_members', new sfValidatorInteger(
  		array('required' => false, 'min' => 0),
  		array('min' => 'The max. number of members must be positive.',
  			  'invalid' => 'The max. number of members must be an integer.')
  		));
  		
  		$this->setValidator('extra_cost', new sfValidatorNumber(
  		array('required' => false, 'min' => 0),
  		array('min' => 'The extra cost must be positive.',
  			  'invalid' => 'The extra cost must be a number.')
  		));
  		
	    /*-------------------------------WIDGETS ATTRIBUTES--------------------------------------*/
  		
	    $this->widgetSchema->setNameFormat('%s');
	    
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	
	}
	
}