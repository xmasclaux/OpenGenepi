<?php

/**
 * Imputation form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImputationForm extends BaseImputationForm
{
  public function configure()
  {
  	
  	/*---------------------------------- WIDGETS CONFIGURATION ----------------------------------*/
  	
  	foreach($this->getOption('users', array()) as $user_id){
  		
  		$this->widgetSchema['method_of_payment_id_'.$user_id] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ImputationMethodOfPayment'), 'add_empty' => false));
  		
  		$this->validatorSchema['method_of_payment_id_'.$user_id] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ImputationMethodOfPayment')));
  		
  		$this->setDefaults(array(
  			'method_of_payment_id_'.$user_id => ParametersConfiguration::getDefault('default_method_of_payment')
  		));
  	}
  	
  	foreach($this->getOption('users', array()) as $user_id){
  		
  		$this->widgetSchema['user_id_'.$user_id] = new sfWidgetFormInputText();
  		
  		$this->validatorSchema['user_id_'.$user_id] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false));
  	
  		$this->widgetSchema['user_id_'.$user_id]->setAttribute('value', $user_id);
  		
  		$this->widgetSchema['user_id_'.$user_id]->setAttribute('type', 'hidden');
  	}
  	
  	$this->widgetSchema['user_id'] = new sfWidgetFormInputHidden(
  			array(),
  			array('readonly' => 'readonly'));
  			
  	$this->widgetSchema['act_id'] = new sfWidgetFormInputHidden(
  			array(),
  			array('readonly' => 'readonly'));
  			
  	$this->widgetSchema['moderator_id'] = new sfWidgetFormInputHidden(
  			array(),
  			array('readonly' => 'readonly'));
  			
  	$this->widgetSchema['imputation_type'] = new sfWidgetFormInputHidden(
  			array(),
  			array('readonly' => 'readonly'));
  			
  	$this->widgetSchema['comment'] = new sfWidgetFormTextarea();
  	
  	$this->widgetSchema['date'] = new sfWidgetFormI18nDateTime(array('culture' => $this->getOption('culture')));
  	
  	$this->widgetSchema['total']->setAttribute('size', 5);
  	
  	/*---------------------------------- VALIDATORS CONFIGURATION ----------------------------------*/
  	
  	$this->validatorSchema['date']->setOption('required', true);
  	$this->validatorSchema['date']->setMessage('invalid', 'The date/time format is invalid.');
  	
  	$this->validatorSchema['user_id']->setOption('required', true);
  	$this->validatorSchema['total']->setOption('required', true);
  	$this->validatorSchema['account_id']->setOption('required', true);

  	
  	if($this->getOption('imputation_type') != ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE){
  		
  		$this->validatorSchema['room_id']->setOption('required', true);
  		$this->validatorSchema['building_id']->setOption('required', true);
  		$this->validatorSchema['act_id']->setOption('required', true);
  		
  	}
  	
  	
  		/*--------------- MODIFICATION OF THE 'TOTAL' WIDGET IN 2 PARTICULAR CASE:-----------------*/
  	
  		if(($this->getOption('imputation_type') == ImputationDefaultValues::COUNTABLE_SERVICE_TYPE)
  			|| ($this->getOption('imputation_type') == ImputationDefaultValues::SUBSCRIPTION_TYPE)){  	
		  			  	
		  	$this->widgetSchema->setLabel('total', 'Price');
		  	
  		}

  		/*--------------------- MODIFICATION OF THE 'UNITY_ID' WIDGET IN 4 CASES:-------------------*/
  		
  		if($this->getOption('imputation_type') != ImputationDefaultValues::COUNTABLE_SERVICE_TYPE){
  			
  			$this->widgetSchema['unity_id'] = new sfWidgetFormInputHidden();
  			
  		}

  		/*------------------------- ACCOUNTS WHOSE BELONGS TO THE USERS:----------------------------*/
  	
	  	$userAccounts = Doctrine::getTable('AccountUser')->findByUserId($this->getObject()->getUser()->getId());
	
	  	
	  	$user_account_designations = array(0 => '');
  		foreach($userAccounts as $userAccount){
	  		if($this->getOption('imputation_type') == ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE){
	  			
	  			$user_account_designations[$userAccount->getAccount()->getId()] = $userAccount->getAccount()->getAct()->getDesignation();

	  		}else{
	  			if($userAccount->getAccount()->getMonetaryAccount() == 1){
	  				$user_account_designations[$userAccount->getAccount()->getId()] = $userAccount->getAccount()->getAct()->getDesignation();
	  			}
	  		}
	  	}
	  	
	  	$this->widgetSchema['account_id'] = new sfWidgetFormChoice(array(
	  			'choices'  => $user_account_designations,
	  			'multiple' => false,
	  			'expanded' => false));
	  	
	  	$this->validatorSchema['account_id'] = new sfValidatorChoice(array(
	  			'choices' => array_keys($user_account_designations)), array(
	  			'invalid' => 'the account id is invalid'));
	  	
	  	foreach($this->getOption('users', array()) as $user_id){
	  		
	  		$userAccounts = Doctrine::getTable('AccountUser')->findByUserId($user_id);
	
	  	
		  	$user_account_designations = array(0 => '');
		  	foreach($userAccounts as $userAccount){
		  		if($this->getOption('imputation_type') == ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE){
		  			
		  			$user_account_designations[$userAccount->getAccount()->getId()] = $userAccount->getAccount()->getAct()->getDesignation();

		  		}else{
		  			if($userAccount->getAccount()->getMonetaryAccount() == 1){
		  				$user_account_designations[$userAccount->getAccount()->getId()] = $userAccount->getAccount()->getAct()->getDesignation();
		  			}
		  		}
		  	}
		  	
		  	$this->widgetSchema['account_id_'.$user_id] = new sfWidgetFormChoice(array(
		  			'choices'  => $user_account_designations,
		  			'multiple' => false,
		  			'expanded' => false));
		  	
		  	$this->validatorSchema['account_id_'.$user_id] = new sfValidatorChoice(array(
		  			'choices' => array_keys($user_account_designations)), array(
		  			'invalid' => 'the account id is invalid'));
	  		
	  	}
  	
  	
  	
  		/*--------------------------------- CORRESPONDING ACT:------------------------------------*/
	  	if($this->getOption('imputation_type') != ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE){
	  		//Set the default act id:
	  		$this->widgetSchema->setDefault('act_id', $this->getObject()->getAct()->getId());
	  		
	  	}
  	
  	
  	
  	/*------------------------------------------ LABELS --------------------------------------------*/
  	$this->widgetSchema->setLabel('date','Date and Time');
  	
  	$this->widgetSchema->setLabel('moderator_id','Animator');
  	
  	$this->widgetSchema->setLabel('account_id','Concerned Account');
  	
  	if($this->getOption('imputation_type') == ImputationDefaultValues::ACCOUNT_TRANSACTION_TYPE){
  		$this->widgetSchema->setLabel('method_of_payment_id','Paid by');
  	}else{
  		$this->widgetSchema->setLabel('method_of_payment_id','Pay by');
  	}
  }
}
