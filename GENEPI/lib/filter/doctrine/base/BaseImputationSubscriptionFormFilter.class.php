<?php

/**
 * ImputationSubscription filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationSubscriptionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'number_of_members' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'final_date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'imputation_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'number_of_members' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'final_date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'imputation_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Imputation'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('imputation_subscription_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationSubscription';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'number_of_members' => 'Number',
      'final_date'        => 'Date',
      'imputation_id'     => 'ForeignKey',
    );
  }
}
