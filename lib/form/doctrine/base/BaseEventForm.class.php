<?php

/**
 * Event form base class.
 *
 * @method Event getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseEventForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'designation'    => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'description'    => new sfValidatorString(array('required' => false)),
      'reservation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'))),
    ));

    $this->widgetSchema->setNameFormat('event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Event';
  }

}
