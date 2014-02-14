<?php

/**
 * Moderator form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ModeratorForm extends BaseModeratorForm
{
  public function configure()
  {
  	
  	$this->setValidator('email', new sfValidatorEmail(
   		array('required' => false), 
   		array('invalid'  => 'This email address is invalid.') 
  	));
  	
  	$this->validatorSchema['login_id']->addOption('required', false);
  					
  	/*Add an embed login form*/	
  	$subFormLogin = new LoginForm($this->getObject()->getLogin(), $this->getOptions());
  	$subFormLogin->widgetSchema->setLabel('login', 'Login');
  	$this->embedForm('login', $subFormLogin);
  	
  }
}
