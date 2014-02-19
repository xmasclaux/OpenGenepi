<?php

/**
 * Account filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAccountFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'monetary_account' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'act_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'value'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monetary_account' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'act_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Act'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('account_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Account';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'value'            => 'Number',
      'monetary_account' => 'Number',
      'created_at'       => 'Date',
      'act_id'           => 'ForeignKey',
    );
  }
}
