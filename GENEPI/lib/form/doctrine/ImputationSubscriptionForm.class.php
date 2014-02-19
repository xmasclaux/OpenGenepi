<?php

/**
 * ImputationSubscription form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImputationSubscriptionForm extends BaseImputationSubscriptionForm
{
  public function configure()
  {
  	
  	$this->disableLocalCSRFProtection();
  	
  	/*---------------------------------- WIDGETS CONFIGURATION ----------------------------------*/
  		
  	$this->widgetSchema['final_date'] = new sfWidgetFormI18nDate(array('culture' => $this->getOption('culture')));
  	
  	$this->widgetSchema['number_of_members'] = new sfWidgetFormInputHidden();
  	
  	/*---------------------------------- VALIDATORS CONFIGURATION ----------------------------------*/
  	
  	$this->validatorSchema['imputation_id']->addOption('required', false);
  	
  	
  	/*-------------------------------------------- LABELS ------------------------------------------*/
  	
  	
  	$this->validatorSchema['final_date']->setMessage('invalid', 'The date/time format is invalid.');
  	
  	
  	/*--------------------------------------- FORMS EMBEDDING --------------------------------------*/

	  	/* --- Embed a imputation form: --- */
	  	$subFormImputation = new ImputationForm($this->getObject()->getImputation(), array_merge(
	  		$this->getOptions(),
	  		array('imputation_type' => ImputationDefaultValues::SUBSCRIPTION_TYPE)));
	  		
	  	$this->embedForm('imputation', $subFormImputation);

  }
}
