<?php

/**
 * ImputationCountableService form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImputationCountableServiceForm extends BaseImputationCountableServiceForm
{
  public function configure()
  {
  	
  	$this->disableLocalCSRFProtection();
  	/*---------------------------------- WIDGETS CONFIGURATION ----------------------------------*/
  		
  	if($this->getOption('users', array()) != array()){
  		$this->widgetSchema['account_is_shared'] = new inputCheckboxFixed();
  		
  		$this->setValidator('account_is_shared', new sfValidatorBoolean());
  		
  		$this->widgetSchema->setLabel('account_is_shared', 'This account will be shared between all these users');
  	}
  	
  	
  	
  	/*---------------------------------- VALIDATORS CONFIGURATION ----------------------------------*/
  	
  	$this->validatorSchema['imputation_id']->addOption('required', false);
  	

  	/*-------------------------------------------- LABELS ------------------------------------------*/
  	
  	$this->widgetSchema->setLabel('initial_value', 'Initial value');
  	

  	/*--------------------------------------- FORMS EMBEDDING --------------------------------------*/

	  	/* --- Embed a imputation form: --- */
	  	$subFormImputation = new ImputationForm($this->getObject()->getImputation(), array_merge(
	  		$this->getOptions(),
	  		array('imputation_type' => ImputationDefaultValues::COUNTABLE_SERVICE_TYPE)));
	  		
	  	$this->embedForm('imputation', $subFormImputation);

	  	
	  	/* --- Embed an account form: --- */
	  	$subFormAccount = new AccountForm();
	  	$this->embedForm('account', $subFormAccount);
  }
  
}
