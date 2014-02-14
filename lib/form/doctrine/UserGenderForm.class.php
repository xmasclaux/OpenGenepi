<?php

/**
 * UserGender form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserGenderForm extends BaseUserGenderForm
{
  public function configure()
  {
  	$userGenders = Doctrine::getTable('UserGender')->findAll();
  	
  	foreach($userGenders as $userGender) $genders[$userGender->id] = $userGender->designation;
  	
  	$this->widgetSchema['designation'] = new sfWidgetFormChoice(array(
  		'choices'  => $genders,
 		'expanded' => false, 
 		'multiple' => false ));
  	
  	$this->widgetSchema->setLabels(array(
  		'designation' => 'Sex'));	
  }
}
