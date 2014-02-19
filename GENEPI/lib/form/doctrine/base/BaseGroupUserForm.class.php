<?php

/**
 * GroupUser form base class.
 *
 * @method GroupUser getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseGroupUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'group_id' => new sfWidgetFormInputText(),
      'user_id'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'group_id' => new sfValidatorInteger(),
      'user_id'  => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('group_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GroupUser';
  }

}
