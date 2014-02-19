<?php

/**
 * A form to change the categories of the users
 *
 * @package    epi
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class ChangeUsersCategoriesForm extends sfForm{
	
	public function setup(){
		
		$category_choices = array();
		
		$category_choices_query = Doctrine_Query::create()
	      	->select('a.*')
	    	->from('ActPublicCategory a')
	    	->orderBy('a.sort_order');
	    $category_choices_res = $category_choices_query->fetchArray();
	    
		foreach($category_choices_res as $category){
	    	$category_choices[$category['id']] = $category['designation'];
	    }
		
		foreach($this->getOption('users', array()) as $user){
			
			$user_id = $user->getId();
						
			/*----------------------------------WIDGETS----------------------------------------------*/
	  		
			$this->widgetSchema['ids['.$user_id.']'] = new sfWidgetFormInputText();
			
	  		$this->widgetSchema['name['.$user_id.']'] = new sfWidgetFormInputText();
	  		
	  		$this->widgetSchema['category['.$user_id.']'] = new sfWidgetFormSelect(array('choices' => $category_choices));
	  		
	  		
	  		/*-----------------------------------VALIDATORS-------------------------------------------*/
	  		
	  		$this->validatorSchema['ids['.$user_id.']'] = new sfValidatorNumber();
			
	  		$this->validatorSchema['name['.$user_id.']'] = new sfValidatorString();
	  		
	  		$this->validatorSchema['category['.$user_id.']'] = new sfValidatorInteger(array('min' => 0));
	  		
	  		
	  		/*-----------------------------------DEFAULTS-------------------------------------------*/
	  		
	  		$this->widgetSchema['ids['.$user_id.']']->setAttribute('value', $user_id);
  		
  			$this->widgetSchema['ids['.$user_id.']']->setAttribute('type', 'hidden');
  			
  			$this->widgetSchema['name['.$user_id.']']->setAttribute('value', $user);
  			
  			$this->setDefault('category['.$user_id.']', $user->getActPublicCategoryId());

	  	}
	    
  		
	    /*-------------------------------WIDGETS ATTRIBUTES--------------------------------------*/
	    
	    $this->widgetSchema->setNameFormat('change_category[%s]');
	    
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	
	}
	
}