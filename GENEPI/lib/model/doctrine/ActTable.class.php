<?php

class ActTable extends Doctrine_Table
{
	public function savePurchase($values)
	{
		$newPurchase = new Act();
		$newPurchase->setDesignation($values['designation']);
		$newPurchase->setShortenedDesignation($values['shortened_designation']);
		$newPurchase->setComment($values['comment']);
		$newPurchase->setActTypeId($values['act_type_id']);
		$newPurchase->setDisabled(0);
		$newPurchase->save();
		
		ActTable::createActPrice($newPurchase->id);
	}
	
	public function updatePurchase($values,$purchase)
	{
		$updatedPurchase = Doctrine::getTable('Act')->findOneById($purchase);
		$updatedPurchase->setComment($values['comment']);
		$updatedPurchase->save();
	}
	
	public function saveSubscription($values)
	{
		$newSubscription = new Act();
		$newSubscription->setDesignation($values['designation']);
		$newSubscription->setShortenedDesignation($values['shortened_designation']);
		$newSubscription->setComment($values['comment']);
		$newSubscription->setDuration($values['duration']);
		$newSubscription->setMaxMembers($values['max_members']);
		$newSubscription->setExtraCost($values['extra_cost']);
		$newSubscription->setActTypeId($values['act_type_id']);
		$newSubscription->setDisabled(0);
		$newSubscription->save();
		
		ActTable::createActPrice($newSubscription->id);
	}
	
	public function updateSubscription($values,$subscription)
	{
		$updatedSubscription = Doctrine::getTable('Act')->findOneById($subscription);
		$updatedSubscription->setComment($values['comment']);
		$updatedSubscription->setDuration($values['duration']);
		$updatedSubscription->setMaxMembers($values['max_members']);
		$updatedSubscription->setExtraCost($values['extra_cost']);
		$updatedSubscription->save();
	}
	
	public function saveUnitaryService($values)
	{
		$newUnitaryService = new Act();
		$newUnitaryService->setDesignation($values['designation']);
		$newUnitaryService->setShortenedDesignation($values['shortened_designation']);
		$newUnitaryService->setComment($values['comment']);
		$newUnitaryService->setDuration($values['duration']);
		$newUnitaryService->setBeginningDatetime($values['beginning_datetime']);
		$newUnitaryService->setEndDate($values['end_date']);
		$newUnitaryService->setRecurrence($values['recurrence']);
		$newUnitaryService->setActTypeId($values['act_type_id']);
		$newUnitaryService->setDisabled(0);
		$newUnitaryService->save();
		
		ActTable::createActPrice($newUnitaryService->id);
	}
	
	public function updateUnitaryService($values,$unitaryService)
	{
		$updatedUnitaryService = Doctrine::getTable('Act')->findOneById($unitaryService);
		$updatedUnitaryService->setComment($values['comment']);
		$updatedUnitaryService->setDuration($values['duration']);
		$updatedUnitaryService->setBeginningDatetime($values['beginning_datetime']);
		$updatedUnitaryService->setEndDate($values['end_date']);
		$updatedUnitaryService->setRecurrence($values['recurrence']);
		$updatedUnitaryService->save();
	}
	
	public function saveMultipleService($values)
	{
		$newMultipleService = new Act();
		$newMultipleService->setDesignation($values['designation']);
		$newMultipleService->setShortenedDesignation($values['shortened_designation']);
		$newMultipleService->setComment($values['comment']);
		$newMultipleService->setQuantity($values['quantity']);
		$newMultipleService->setUnityId($values['unity_id']);
		$newMultipleService->setMonetaryAccount($values['monetary_account']);
		$newMultipleService->setActTypeId($values['act_type_id']);
		$newMultipleService->setDisabled(0);
		$newMultipleService->save();
		
		ActTable::createActPrice($newMultipleService->id);
	}
	
	public function updateMultipleService($values,$multipleService)
	{
		$updatedMultipleService = Doctrine::getTable('Act')->findOneById($multipleService);
		$updatedMultipleService->setComment($values['comment']);
		$updatedMultipleService->setQuantity($values['quantity']);
		$updatedMultipleService->setUnityId($values['unity_id']);
		$updatedMultipleService->save();
	}
	
	public function disableAct($act)
	{
		$disabledAct = Doctrine::getTable('Act')->findOneById($act);
		$disabledAct->setDisabled(1);
		$disabledAct->save();
	}
	
	public function createActPrice($id)
	{
		$publicCategories = Doctrine::getTable('ActPublicCategory')
      		->createQuery('a')
      		->execute();
      
      	foreach ($publicCategories as $publicCategory)
		{
			$newActPrice = new ActPrice();
			$newActPrice->setActId($id);
			$newActPrice->setActPublicCategoryId($publicCategory->getId());
			$newActPrice->setValue(-1);
			$newActPrice->save();
		}
	}
}
