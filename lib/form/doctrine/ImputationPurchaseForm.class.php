<?php

/**
 * ImputationPurchase form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImputationPurchaseForm extends BaseImputationPurchaseForm
{
  public function configure()
  {
  	
  	$this->disableLocalCSRFProtection();
  	
  	/*---------------------------------- WIDGETS CONFIGURATION ----------------------------------*/
  	 	
  	
  	$this->widgetSchema['unitary_price'] = new sfWidgetFormInputText();
  	
  	$act_price = Doctrine::getTable('ActPrice')
  				->findOneByActIdAndActPublicCategoryId(
  					$this->getObject()->getImputation()->getActId(),
  					$this->getOption('public_category')
  			);
  	
  	if($act_price['value'] == -1){
  		$this->widgetSchema->setDefault('unitary_price', 0);
  	}else{
  		$this->widgetSchema->setDefault('unitary_price', $act_price['value']);
  	}
  
  	
  	$this->widgetSchema->setDefault('number_of_unities', 1);
  	
  	
  	
  	/*---------------------------------- VALIDATORS CONFIGURATION ----------------------------------*/
  	
  	$this->validatorSchema['imputation_id']->addOption('required', false);
  	
  	$this->validatorSchema['unitary_price'] = new sfValidatorNumber();
  	
  	
  	
  	/*-------------------------------------------- LABELS ------------------------------------------*/
  	
  	$this->widgetSchema->setLabel('unitary_price', 'Unitary price');
  	
  	$this->widgetSchema->setLabel('number_of_unities', 'Quantity');
  	
  	
  	/*--------------------------------------- FORMS EMBEDDING --------------------------------------*/

	  	/*Embed a imputation form:*/
	  	$subFormImputation = new ImputationForm($this->getObject()->getImputation(), array_merge(
	  		$this->getOptions(),
	  		array('imputation_type' => ImputationDefaultValues::PURCHASE_TYPE)));
	  		
	  	$this->embedForm('imputation', $subFormImputation);
	  	
  	
  }
}
