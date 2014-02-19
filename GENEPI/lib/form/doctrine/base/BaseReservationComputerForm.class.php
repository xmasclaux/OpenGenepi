<?php

/**
 * ReservationComputer form base class.
 *
 * @method ReservationComputer getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReservationComputerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => false)),
      'computer_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Computer'), 'add_empty' => false)),
      'start_date'     => new sfWidgetFormDateTime(),
      'end_date'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'reservation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'))),
      'computer_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Computer'))),
      'start_date'     => new sfValidatorDateTime(),
      'end_date'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('reservation_computer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ReservationComputer';
  }

}
