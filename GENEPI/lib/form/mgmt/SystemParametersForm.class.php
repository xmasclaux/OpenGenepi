<?php

/**
 * System Parameters form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class SystemParametersForm extends sfForm{
	
	public function setup(){
		
		$dbms = array('mysql' => 'MySQL', 'pgsql' => 'PostgreSQL');
		
		/*----------------------------------WIDGETS----------------------------------------------*/
		
	  	$this->setWidgets(array(
	  		'ip_address'        => new sfWidgetFormInputText(),
	  		'srv_port'          => new sfWidgetFormInputText(),
	    	'dbms'              => new sfWidgetFormSelect(array('choices' => $dbms)),
	   		'db_name'           => new sfWidgetFormInputText(),
	    	'db_user_name'      => new sfWidgetFormInputText(),
	    	'db_password'       => new sfWidgetFormInputPassword()

	    ));
		
	    $this->widgetSchema->setLabels(array(
	    	'ip_address'        => 'Address',
	  		'srv_port'          => 'Port',
	    	'dbms'              => 'DBMS',
	   		'db_name'           => 'Database name',
	    	'db_user_name'      => 'Username',
	    	'db_password'       => 'Password'
	    ));
	    
	    /*-----------------------------------VALIDATORS-------------------------------------------*/
	    
	    $this->setValidators(array(
	    	'ip_address'   => new sfValidatorString(),
	    		
	    	'srv_port'     => new sfValidatorInteger(array('max' => 65535, 'min' => 0)),
	    		
	    	'dbms'         => new sfValidatorInteger(array('max' => 2, 'min' => 1)),
	    		
	    	'db_name'      => new sfValidatorString(),
	    		
	    	'db_user_name' => new sfValidatorString(),
	    		
	    	'db_password'  => new sfValidatorString(array('required' => false)),

	    ));
	
	    /*-------------------------------WIDGETS ATTRIBUTES--------------------------------------*/
	    
	    //$this->widgetSchema['srv_port']->setAttribute('readonly' , 'readonly');
	    $this->widgetSchema['db_password']->setAttribute('autocomplete' , 'off');
	    
	    $this->widgetSchema->setNameFormat('%s');
	    
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	
	}
	
	
	
	
	public function checkIPFormat(sfValidatorBase $validator, $value){
				
		$ip_array = explode(".",$value);
		$length = 0;
		
		foreach($ip_array as $ip_digit){
			$length++;
			if(($ip_digit < 0) || ($ip_digit > 255)){
				throw new sfValidatorError($validator, 'invalid');
			}
		}
		
		if($length == 4){
			return $value;
		}else{
			throw new sfValidatorError($validator, 'invalid');
		}
	}
}
