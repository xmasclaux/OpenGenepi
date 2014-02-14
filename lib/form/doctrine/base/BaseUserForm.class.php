<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInputText(),
      'surname'                => new sfWidgetFormInputText(),
      'birthdate'              => new sfWidgetFormDate(),
      'created_at'             => new sfWidgetFormDateTime(),
      'organization_name'      => new sfWidgetFormInputText(),
      'email'                  => new sfWidgetFormInputText(),
      'cellphone_number'       => new sfWidgetFormInputText(),
      'password'			   => new sfWidgetFormInputText(),
      'comment'                => new sfWidgetFormInputText(),
      'user_gender_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserGender'), 'add_empty' => true)),
      'user_seg_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserSeg'), 'add_empty' => true)),
      'address_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Address'), 'add_empty' => true)),
      'user_awareness_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserAwareness'), 'add_empty' => true)),
      'login_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Login'), 'add_empty' => true)),
      'act_public_category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActPublicCategory'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 45)),
      'surname'                => new sfValidatorString(array('max_length' => 45)),
      'birthdate'              => new sfValidatorDate(),
      'created_at'             => new sfValidatorDateTime(),
      'organization_name'      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'email'                  => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'cellphone_number'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'password'               => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'comment'                => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'user_gender_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserGender'), 'required' => false)),
      'user_seg_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserSeg'), 'required' => false)),
      'address_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Address'), 'required' => false)),
      'user_awareness_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserAwareness'), 'required' => false)),
      'login_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Login'), 'required' => false)),
      'act_public_category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ActPublicCategory'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
