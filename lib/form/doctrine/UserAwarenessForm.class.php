<?php

/**
 * UserAwareness form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserAwarenessForm extends BaseUserAwarenessForm
{
  public function configure()
  {
  	/*
  	$this->setWidgets(array(
      	'newAwareness' => new sfWidgetFormInput(),
    ));

    $awarenesses[] = "";
    
  	$userAwarenesses= Doctrine::getTable('UserAwareness')->findAll();
  	foreach($userAwarenesses as $userAwareness) $awarenesses[$userAwareness->id] = $userAwareness->designation;
 
  	$awarenesses[] = "Other";
  	
  	$this->widgetSchema['designation'] = new sfWidgetFormChoice(array(
  		'choices'  => $awarenesses,
 		'expanded' => false, 
 		'multiple' => false,
  	));
  	
  	$this->widgetSchema->setLabels(array(
  		'designation' => 'EPI Awareness'));
  	
  	$this->setValidators(array(
      'newAwareness'      => new sfValidatorString(array('required' => false)),
  	  'designation' 	  => new sfValidatorString(array('required' => false)),
    ));*/
  }
}
