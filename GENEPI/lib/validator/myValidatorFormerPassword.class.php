<?php

class myValidatorFormerPassword extends sfValidatorString{
	
	protected function configure($options = array(), $messages = array()){
		
		$this->addOption('id');
		
		$this->addMessage('id', 'The entry id has not been specified.');
		
		parent::configure($options,$messages);
		
	}
	
	protected function doClean($value){
		
		$validatedString = parent::doClean($value);
		
		if($this->hasOption('id')){
			
			$specified_pass = ModeratorManagement::asMd5WithPrefix($validatedString);
			$former_pass = ModeratorManagement::getPasswordAsMd5($this->getOption('id'));
			
			if($specified_pass != $former_pass){
				throw new sfValidatorError($this, 'You have specified an invalid former password.');
			}
			
		}else{
			throw new sfValidatorError($this, 'id');
		}
	}
}