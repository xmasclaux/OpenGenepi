<?php

/**
 * ImputationUnitaryService form base class.
 *
 * @method ImputationUnitaryService getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationUnitaryServiceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'number_of_unities' => new sfWidgetFormInputText(),
      'beginning_time'    => new sfWidgetFormTime(),
      'end_time'          => new sfWidgetFormTime(),
      'computer_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Computer'), 'add_empty' => true)),
      'imputation_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'number_of_unities' => new sfValidatorInteger(),
      'beginning_time'    => new sfValidatorTime(),
      'end_time'          => new sfValidatorTime(),
      'computer_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Computer'), 'required' => false)),
      'imputation_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('imputation_unitary_service[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationUnitaryService';
  }

}
