<?php

/**
 * Multiple service form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class MultipleServiceForm extends sfForm{
	
	public function setup(){
		
		//Get the unities designation:
		$unities = array(0 => '');
		$unities_query = Doctrine_Query::create()
	      	->select('u.designation')
	    	->from('Unity u')
	    	->where('u.disabled <> 1')
	    	->orderBy('u.sort_order');
	    $unities_res = $unities_query->fetchArray();
	    foreach($unities_res as $unity){
	    	$unities[$unity['id']] = $unity['designation'];
	    }
		
		
		/*----------------------------------WIDGETS----------------------------------------------*/
		
	  	$this->setWidgets(array(
	  		'designation' 			        => new sfWidgetFormInputText(),
	  		'shortened_designation' 	    => new sfWidgetFormInputText(),
	  		'comment' 						=> new sfWidgetFormTextarea(),
			'quantity' 			       		=> new sfWidgetFormInputText(),
	  		'monetary_account'				=> new sfWidgetFormInputCheckbox(),
	  		'unity_id' 			       		=> new sfWidgetFormSelect(array('choices' => $unities)),
	  		'act_type_id'					=> new sfWidgetFormInputHidden(),
	    ));
	    
	    $this->widgetSchema->setLabels(array(
	    	'designation'                   => 'Act name',
	  		'shortened_designation'         => 'Shortened name',
			'quantity'						=> 'Initial quantity',
	    ));
	    
	    $this->widgetSchema->setDefaults(array(
	    	'act_type_id'                  => '3',
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
  		
  		$this->setValidator('quantity', new sfValidatorNumber(
  		array('required' => true, 'min' => 0),
  		array('min' => 'The quantity must be positive.',
  			  'invalid' => 'The quantity must be a number.',
  			  'required' => 'The initial quantity field is compulsory.')
  		));
  		
  		$this->setValidator('unity_id', new sfValidatorString(
     	array('required' => false),
     	array()
  		));
  		
  		$this->setValidator('act_type_id', new sfValidatorString(
     	array('required' => true)
  		));
  		
  		$this->setValidator('monetary_account', new sfValidatorString(
     	array('required' => false)
  		));
  		
	    /*-------------------------------WIDGETS ATTRIBUTES--------------------------------------*/
	    
	    $this->widgetSchema->setNameFormat('%s');
	    $this->widgetSchema->setLabel('monetary_account', 'Monetary account');
	    
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	
	}
	
}