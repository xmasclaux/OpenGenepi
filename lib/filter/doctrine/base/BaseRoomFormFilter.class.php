<?php

/**
 * Room filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseRoomFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'shortened_designation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'               => new sfWidgetFormFilterInput(),
      'building_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Building'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'designation'           => new sfValidatorPass(array('required' => false)),
      'shortened_designation' => new sfValidatorPass(array('required' => false)),
      'comment'               => new sfValidatorPass(array('required' => false)),
      'building_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Building'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('room_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Room';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'designation'           => 'Text',
      'shortened_designation' => 'Text',
      'comment'               => 'Text',
      'building_id'           => 'ForeignKey',
    );
  }
}
