<?php

/**
 * ImputationCountableService filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationCountableServiceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'initial_value' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'imputation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'initial_value' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'imputation_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Imputation'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('imputation_countable_service_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationCountableService';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'initial_value' => 'Number',
      'imputation_id' => 'ForeignKey',
    );
  }
}
