<?php

/**
 * ImputationAccountTransaction form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImputationAccountTransactionForm extends BaseImputationAccountTransactionForm
{
  public function configure()
  {
  	
  	$this->disableLocalCSRFProtection();
  	/*---------------------------------- WIDGETS CONFIGURATION ----------------------------------*/
  			

  	$subFormImputation->widgetSchema['room_id'] = new sfWidgetFormInputHidden(
  			array(),
  			array('readonly' => 'readonly'));
  			
  	$subFormImputation->widgetSchema['building_id'] = new sfWidgetFormInputHidden(
  			array(),
  			array('readonly' => 'readonly'));
  			
  	$this->widgetSchema['unitary_price'] = new sfWidgetFormInputText(array(), array('size' => 5));
  	$this->widgetSchema->setDefault('unitary_price', 1);
  	
  	$this->widgetSchema['quantity'] = new sfWidgetFormInputText(array(), array('size' => 5));
  	
  	$this->widgetSchema['sum']->setAttribute('size', 5);
  			
  			
  	/*---------------------------------- VALIDATORS CONFIGURATION ----------------------------------*/
  			
  	$this->validatorSchema['imputation_id']->addOption('required', false);
  	
  	$this->validatorSchema['designation']->addOption('required', false);
  	
  	$this->validatorSchema['unitary_price'] = new sfValidatorNumber(array(
  			'min'      => 0,
  			'required' => false), array(
  			'min' => 'The unitary price must exceed %min_length%'));
  	
  	$this->validatorSchema['quantity'] = new sfValidatorNumber(array(
  			'min'      => 0,
  			'required' => false), array(
  			'min' => 'The quantity must exceed %min_length%'));
  	
  	
  	/*-------------------------------------------- LABELS ------------------------------------------*/
  	
  	$this->widgetSchema->setLabel('unitary_price', 'Unitary price');
  	
  	$this->widgetSchema->setLabel('sum', 'Quantity');
  	
  	
  	/*--------------------------------------- FORMS EMBEDDING --------------------------------------*/

	  	/*Embed a imputation form:*/
	  	$subFormImputation = new ImputationForm($this->getObject()->getImputation(), array_merge(
	  			$this->getOptions(),
	  			array('imputation_type' => ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE)));
	  		
	  	$this->embedForm('imputation', $subFormImputation);
	  	
	  	
	  	
	  	/*Add a new widget in case of the account transaction is paid with an account:*/
	  	$userAccounts = Doctrine::getTable('AccountUser')->findByUserId($this->getObject()->getImputation()->getUser()->getId());
	
	  	
	  	$user_account_designations = array(0 => '');
  		foreach($userAccounts as $userAccount){
  			if($userAccount->getAccount()->getMonetaryAccount() == 1){
  				$user_account_designations[$userAccount->getAccount()->getId()] = $userAccount->getAccount()->getAct()->getDesignation();
  			}
	  	}
	  	
	  	$this->widgetSchema['account_to_pay_id'] = new sfWidgetFormChoice(array(
	  			'choices'  => $user_account_designations,
	  			'multiple' => false,
	  			'expanded' => false));
	  	
	  	$this->validatorSchema['account_to_pay_id'] = new sfValidatorChoice(array(
	  			'choices' => array_keys($user_account_designations)), array(
	  			'invalid' => 'the account id is invalid'));

  		$this->validatorSchema['account_to_pay_id']->addOption('required', false);
  	
  }
}
