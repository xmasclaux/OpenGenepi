<?php

/**
 * Account form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AccountForm extends BaseAccountForm
{
  public function configure()
  {
  		$this->validatorSchema['value']->addOption('required', false);
  	
  		$this->validatorSchema['monetary_account']->addOption('required', false);
  		
  		$this->validatorSchema['created_at']->addOption('required', false);
  		
  		$this->validatorSchema['act_id']->addOption('required', false);
  }
}
