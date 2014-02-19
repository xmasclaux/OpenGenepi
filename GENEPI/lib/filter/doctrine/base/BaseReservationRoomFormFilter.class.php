<?php

/**
 * ReservationRoom filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseReservationRoomFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => true)),
      'room_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'add_empty' => true)),
      'start_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'reservation_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Reservation'), 'column' => 'id')),
      'room_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Room'), 'column' => 'id')),
      'start_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('reservation_room_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ReservationRoom';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'reservation_id' => 'ForeignKey',
      'room_id'        => 'ForeignKey',
      'start_date'     => 'Date',
      'end_date'       => 'Date',
    );
  }
}
