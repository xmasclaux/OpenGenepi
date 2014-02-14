<?php

/**
 * Room form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RoomForm extends BaseRoomForm
{
  public function configure()
  {
  	$this->widgetSchema['comment'] = new sfWidgetFormTextarea();
  											
  	$this->setValidator('designation', new sfValidatorString(
     	array('max_length' => 45), 
     	array('max_length' => 'The name field must not exceed %max_length% characters.',
     		  'required' => 'The name field is compulsory.')
  	));
  	
  	$this->setValidator('shortened_designation', new sfValidatorString(
     	array('max_length' => 20, 'required' => true), 
     	array('max_length' => 'The shortened name field must not exceed %max_length% characters.',
     		  'required' => 'The shortened name field is compulsory.')
  	));
  	
  	$this->setValidator('comment', new sfValidatorString(
     	array('max_length' => 250, 'required' => false), 
     	array('max_length' => 'The comment field must not exceed %max_length% characters.')
  	));
  	
  	$this->widgetSchema->setLabel('designation', 'Room name');
    $this->widgetSchema->setLabel('shortened_designation', 'Shortened name');
  	
  }
}
