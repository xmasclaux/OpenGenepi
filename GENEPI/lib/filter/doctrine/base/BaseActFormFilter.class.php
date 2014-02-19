<?php

/**
 * Act filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'shortened_designation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'               => new sfWidgetFormFilterInput(),
      'quantity'              => new sfWidgetFormFilterInput(),
      'duration'              => new sfWidgetFormFilterInput(),
      'max_members'           => new sfWidgetFormFilterInput(),
      'extra_cost'            => new sfWidgetFormFilterInput(),
      'disabled'              => new sfWidgetFormFilterInput(),
      'act_type_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActType'), 'add_empty' => true)),
      'unity_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Unity'), 'add_empty' => true)),
      'beginning_datetime'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'end_date'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'recurrence'            => new sfWidgetFormFilterInput(),
      'monetary_account'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'designation'           => new sfValidatorPass(array('required' => false)),
      'shortened_designation' => new sfValidatorPass(array('required' => false)),
      'comment'               => new sfValidatorPass(array('required' => false)),
      'quantity'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'duration'              => new sfValidatorPass(array('required' => false)),
      'max_members'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'extra_cost'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'disabled'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'act_type_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ActType'), 'column' => 'id')),
      'unity_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Unity'), 'column' => 'id')),
      'beginning_datetime'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_date'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'recurrence'            => new sfValidatorPass(array('required' => false)),
      'monetary_account'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('act_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Act';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'designation'           => 'Text',
      'shortened_designation' => 'Text',
      'comment'               => 'Text',
      'quantity'              => 'Number',
      'duration'              => 'Text',
      'max_members'           => 'Number',
      'extra_cost'            => 'Number',
      'disabled'              => 'Number',
      'act_type_id'           => 'ForeignKey',
      'unity_id'              => 'ForeignKey',
      'beginning_datetime'    => 'Date',
      'end_date'              => 'Date',
      'recurrence'            => 'Text',
      'monetary_account'      => 'Number',
    );
  }
}
