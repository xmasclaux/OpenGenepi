<?php

/**
 * Imputation filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'total'                => new sfWidgetFormFilterInput(),
      'imputation_type'      => new sfWidgetFormFilterInput(),
      'comment'              => new sfWidgetFormFilterInput(),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'moderator_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Moderator'), 'add_empty' => true)),
      'account_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'add_empty' => true)),
      'act_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'add_empty' => true)),
      'room_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'add_empty' => true)),
      'building_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Building'), 'add_empty' => true)),
      'method_of_payment_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ImputationMethodOfPayment'), 'add_empty' => true)),
      'unity_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Unity'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'date'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'total'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'imputation_type'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comment'              => new sfValidatorPass(array('required' => false)),
      'user_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'moderator_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Moderator'), 'column' => 'id')),
      'account_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Account'), 'column' => 'id')),
      'act_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Act'), 'column' => 'id')),
      'room_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Room'), 'column' => 'id')),
      'building_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Building'), 'column' => 'id')),
      'method_of_payment_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ImputationMethodOfPayment'), 'column' => 'id')),
      'unity_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Unity'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('imputation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Imputation';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'date'                 => 'Date',
      'total'                => 'Number',
      'imputation_type'      => 'Number',
      'comment'              => 'Text',
      'user_id'              => 'ForeignKey',
      'moderator_id'         => 'ForeignKey',
      'account_id'           => 'ForeignKey',
      'act_id'               => 'ForeignKey',
      'room_id'              => 'ForeignKey',
      'building_id'          => 'ForeignKey',
      'method_of_payment_id' => 'ForeignKey',
      'unity_id'             => 'ForeignKey',
    );
  }
}
