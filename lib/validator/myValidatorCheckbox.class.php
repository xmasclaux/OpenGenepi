<?php

class myValidatorCheckbox extends sfValidatorBase {
	
	protected function configure($options = array(), $messages = array()){
		
		$this->setOption('required', false);
		//parent::configure($options,$messages);
	}
	
	protected function doClean($value){
		
		if(is_null($value) || $value == false){
			return 0;
		}else{
			return 1;
		}
	}
}