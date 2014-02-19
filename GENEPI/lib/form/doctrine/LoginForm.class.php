<?php

/**
 * Login form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LoginForm extends BaseLoginForm
{
  public function configure()
  {
  	/*Login input:*/
  	if($this->getOption('login_readonly')){
  		$this->widgetSchema['login']->setAttribute('readonly', 'readonly');
  	}
  	$this->widgetSchema['login']->setAttribute('autocomplete', 'off');
  	//$this->validatorSchema['login']->setOption('required', true);
  	
  	/*Password input:*/
  	$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array('always_render_empty' => true));
  	$this->widgetSchema->setLabel('password', 'New');
  	$this->setValidator('password',  new sfValidatorString(array(
  				'required'   => true,
  				'min_length' => 6,
  				'max_length' => 32    ), array(
  				'min_length' => 'The password length must exceed %min_length% characters.',
  				'max_length' => 'The password length must not exceed %max_length% characters.')));
  	

  	/*Password confirm input:*/
	$this->widgetSchema['password_confirm'] = new sfWidgetFormInputPassword(array('always_render_empty' => true));
	$this->widgetSchema->setLabel('password_confirm', 'Confirm');
	$this->setValidator('password_confirm',  new sfValidatorString(array(
  				'required'   => false,
  				'min_length' => 6,
  				'max_length' => 32    ), array(
  				'min_length' => 'The password length must exceed %min_length% characters.',
  				'max_length' => 'The password length must not exceed %max_length% characters.')));
	$this->validatorSchema['password']->setOption('required', false);
	  	
	$this->mergePostValidator(new sfValidatorSchemaCompare(
	  			'password',
	  			sfValidatorSchemaCompare::EQUAL, 
	  			'password_confirm', 
	  			array(), 
	  			array('invalid' => 'The password must be the same in the two fields.')));
	  				

  	
  	/*Moderator*/
  	if ( $this->getOption('user_only') )
  	{
  		$this->widgetSchema['is_moderator'] = new sfWidgetFormInputHidden();
  		$this->setValidator('is_moderator', new sfValidatorBoolean());
  		$this->widgetSchema->setLabel('is_moderator', 'Is an administrator');
  	}
  	else
  	{
  		$this->widgetSchema['is_moderator'] = new inputCheckboxFixed();
  		$this->setValidator('is_moderator', new sfValidatorBoolean());
  		$this->widgetSchema->setLabel('is_moderator', 'Is an administrator');
  	}
  	
  	/*Locked input: currently not in use, set to 0 (not locked) by default*/
  	$this->widgetSchema['locked'] = new sfWidgetFormInputHidden();
  	$this->widgetSchema->setDefault('locked', 0);
  	$this->widgetSchema['locked']->addOption("default",0);
  	$this->validatorSchema['locked']->addOption('required', false);

  }
	
}
