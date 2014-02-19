<?php

/**
 * Room form base class.
 *
 * @method Room getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseRoomForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'designation'           => new sfWidgetFormInputText(),
      'shortened_designation' => new sfWidgetFormInputText(),
      'comment'               => new sfWidgetFormInputText(),
      'building_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Building'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'           => new sfValidatorString(array('max_length' => 45)),
      'shortened_designation' => new sfValidatorString(array('max_length' => 20)),
      'comment'               => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'building_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Building'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('room[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Room';
  }

}
