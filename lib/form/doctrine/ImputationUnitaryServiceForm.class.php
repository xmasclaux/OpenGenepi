<?php

/**
 * ImputationUnitaryService form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImputationUnitaryServiceForm extends BaseImputationUnitaryServiceForm
{
  public function configure()
  {
  	
  	$this->disableLocalCSRFProtection();
  	
  	
  	/*---------------------------------- WIDGETS CONFIGURATION ----------------------------------*/
  	
  	foreach($this->getOption('users', array()) as $user_id){
  		
  		$this->widgetSchema['computer_id_'.$user_id] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Computer'), 'add_empty' => false));
  		
  		$this->validatorSchema['computer_id_'.$user_id] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Computer')));
  		
  		$this->setDefaults(array(
  			'computer_id_'.$user_id => ParametersConfiguration::getDefault('default_computer')
  		));
  	}
  	  	
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
  	
  	/*---------------------------------- VALIDATORS CONFIGURATION ----------------------------------*/
  	
  	$this->validatorSchema['imputation_id']->addOption('required', false);
  	
  	$this->validatorSchema['computer_id']->setOption('required', true);
  	
  	$this->validatorSchema['unitary_price'] = new sfValidatorNumber();
  	
  	
  	/*-------------------------------------------- LABELS ------------------------------------------*/
  	
  	$this->widgetSchema->setLabel('computer_id', 'Computer');
  	
  	
  	/*--------------------------------------- FORMS EMBEDDING --------------------------------------*/

	  	/*Embed a imputation form:*/
	  	$subFormImputation = new ImputationForm($this->getObject()->getImputation(), array_merge(
	  		$this->getOptions(),
	  		array('imputation_type' => ImputationDefaultValues::UNITARY_SERVICE_TYPE)));
	  		
	  	$this->embedForm('imputation', $subFormImputation);
  }
}
