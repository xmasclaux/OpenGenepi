<?php

/**
 * ImputationAccountTransaction form base class.
 *
 * @method ImputationAccountTransaction getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationAccountTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'designation'   => new sfWidgetFormInputText(),
      'sum'           => new sfWidgetFormInputText(),
      'imputation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'designation'   => new sfValidatorString(array('max_length' => 45)),
      'sum'           => new sfValidatorNumber(),
      'imputation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Imputation'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('imputation_account_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ImputationAccountTransaction';
  }

}
