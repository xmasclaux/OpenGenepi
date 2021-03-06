<?php

/**
 * ImputationPurchase
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    epi
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class ImputationPurchase extends BaseImputationPurchase
{
	/**
	 * 
	 * @param unknown_type $user_id
	 * @param unknown_type $moderator_id
	 */
	public function preConfigure($user_id, $moderator_id, $act_id, $act_public_category_id = null){
		
		ParametersConfiguration::setUserPrefix(sfContext::getInstance()->getUser()->getAttribute('login'));
		
		//Get the user:
	  	$user = Doctrine::getTable('User')
	  		->findOneById($user_id);
	  		
	  	//Get the moderator:
	  	$moderator = Doctrine::getTable('Moderator')
	  		->findOneById($moderator_id);
	  		
	  	//Get the act:
	  	//Get the moderator:
	  	$act = Doctrine::getTable('Act')
	  		->findOneById($act_id);
	  	
	  	//Set the user for the object ImputationAccountTransaction
	  	$this->getImputation()->setUser($user);
	  	
	  	//If the parameter "follow moderator actions" have been checked: set the moderator for the object ImputationAccountTransaction
	  	if(ParametersConfiguration::getDefault('default_follow_moderator')){
	  		$this->getImputation()->setModerator($moderator);
	  	}else{
	  		//Otherwise, set it to null:
	  		$this->getImputation()->setModeratorId(null);
	  	}
	  	
	  	//Set the act
	  	$this->getImputation()->setAct($act);
	  	
	  	//Set the date (today by default):
	  	$this->getImputation()->setDate(date('m/d/Y H:i'));
	  	
	  	//Set the room, building, method of payment and unity id:
	  	$this->getImputation()->setRoomId(ImputationDefaultValues::getDefaultValueByType(
	  			ImputationDefaultValues::DEFAULT_ROOM, ImputationDefaultValues::PURCHASE_TYPE));
	  		
	  	$this->getImputation()->setBuildingId(ImputationDefaultValues::getDefaultValueByType(
	  			ImputationDefaultValues::DEFAULT_BUILDING, ImputationDefaultValues::PURCHASE_TYPE));
	  			
	  	$this->getImputation()->setMethodOfPaymentId(ParametersConfiguration::getDefault('default_method_of_payment'));
	  	
	  	$this->getImputation()->setUnityId(ParametersConfiguration::getDefault('default_currency'));
	  			
	  	//Set the imputation type to 2:
	  	$this->getImputation()->setImputationType(ImputationDefaultValues::PURCHASE_TYPE);
	}
}
