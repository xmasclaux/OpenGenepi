<?php

/**
 * Event filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseEventFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation'    => new sfWidgetFormFilterInput(),
      'description'    => new sfWidgetFormFilterInput(),
      'reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'designation'    => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'reservation_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Reservation'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Event';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'designation'    => 'Text',
      'description'    => 'Text',
      'reservation_id' => 'ForeignKey',
    );
  }
}
