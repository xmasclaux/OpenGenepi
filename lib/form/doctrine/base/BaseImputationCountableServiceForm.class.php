<?php

/**
 * ImputationCountableService form base class.
 *
 * @method ImputationCountableService getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationCountableServiceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'initial_value' => new sfWidgetFormInputText(),
      'imputation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'initial_value' => new sfValidatorNumber(),
      'imputation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('imputation_countable_service[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationCountableService';
  }

}
