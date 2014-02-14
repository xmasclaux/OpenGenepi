<?php

/**
 * Account form base class.
 *
 * @method Account getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAccountForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'value'            => new sfWidgetFormInputText(),
      'monetary_account' => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'act_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'value'            => new sfValidatorNumber(),
      'monetary_account' => new sfValidatorInteger(),
      'created_at'       => new sfValidatorDateTime(),
      'act_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Act'))),
    ));

    $this->widgetSchema->setNameFormat('account[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Account';
  }

}
