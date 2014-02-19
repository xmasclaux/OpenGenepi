<?php

/**
 * AccountPossession form base class.
 *
 * @method AccountPossession getObject() Returns the current form's model object
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAccountPossessionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'account_id' => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'account_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'account_id', 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('account_possession[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AccountPossession';
  }

}
