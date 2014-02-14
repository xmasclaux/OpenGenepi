<?php

/**
 * UserArchive form base class.
 *
 * @method UserArchive getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserArchiveForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'age'        => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'city_name'  => new sfWidgetFormInputText(),
      'country'    => new sfWidgetFormInputText(),
      'gender'     => new sfWidgetFormInputText(),
      'seg'        => new sfWidgetFormInputText(),
      'awareness'  => new sfWidgetFormInputText(),
      'category'   => new sfWidgetFormInputText(),
      'user_id'    => new sfWidgetFormInputText(),
      'deleted_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'age'        => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'city_name'  => new sfValidatorString(array('max_length' => 90, 'required' => false)),
      'country'    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'gender'     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'seg'        => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'awareness'  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'category'   => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'user_id'    => new sfValidatorInteger(array('required' => false)),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_archive[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserArchive';
  }

}
