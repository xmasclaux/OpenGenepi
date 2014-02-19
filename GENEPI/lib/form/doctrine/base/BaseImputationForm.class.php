<?php

/**
 * Imputation form base class.
 *
 * @method Imputation getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseImputationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'date'                 => new sfWidgetFormDateTime(),
      'total'                => new sfWidgetFormInputText(),
      'imputation_type'      => new sfWidgetFormInputText(),
      'comment'              => new sfWidgetFormInputText(),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'moderator_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Moderator'), 'add_empty' => true)),
      'account_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'add_empty' => true)),
      'act_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'add_empty' => true)),
      'room_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'add_empty' => true)),
      'building_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Building'), 'add_empty' => true)),
      'method_of_payment_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ImputationMethodOfPayment'), 'add_empty' => false)),
      'unity_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Unity'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'date'                 => new sfValidatorDateTime(array('required' => false)),
      'total'                => new sfValidatorNumber(array('required' => false)),
      'imputation_type'      => new sfValidatorInteger(array('required' => false)),
      'comment'              => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'user_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'moderator_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Moderator'), 'required' => false)),
      'account_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'required' => false)),
      'act_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'required' => false)),
      'room_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'required' => false)),
      'building_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Building'), 'required' => false)),
      'method_of_payment_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ImputationMethodOfPayment'))),
      'unity_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Unity'))),
    ));

    $this->widgetSchema->setNameFormat('imputation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Imputation';
  }

}
