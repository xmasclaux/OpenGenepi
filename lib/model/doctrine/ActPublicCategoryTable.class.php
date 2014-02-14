<?php

class ActPublicCategoryTable extends Doctrine_Table
{
	public static function createActPrice($id){
		
		$acts = Doctrine::getTable('Act')
			   	->createQuery('a')
			    ->execute();
		foreach($acts as $act){
			
			if(!$act->getDisabled()){
				
				$newActPrice = new ActPrice();
				$newActPrice->setActId($act->getId());
				$newActPrice->setActPublicCategoryId($id);
				$newActPrice->setValue(-1);
				$newActPrice->save();
			}	
		}
	}
}
