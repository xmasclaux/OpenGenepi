<?php

/**
 * User filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'surname'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'birthdate'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'organization_name'      => new sfWidgetFormFilterInput(),
      'email'                  => new sfWidgetFormFilterInput(),
      'cellphone_number'       => new sfWidgetFormFilterInput(),
      'comment'                => new sfWidgetFormFilterInput(),
      'user_gender_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserGender'), 'add_empty' => true)),
      'user_seg_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserSeg'), 'add_empty' => true)),
      'address_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Address'), 'add_empty' => true)),
      'user_awareness_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserAwareness'), 'add_empty' => true)),
      'login_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Login'), 'add_empty' => true)),
      'act_public_category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActPublicCategory'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                   => new sfValidatorPass(array('required' => false)),
      'surname'                => new sfValidatorPass(array('required' => false)),
      'birthdate'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'organization_name'      => new sfValidatorPass(array('required' => false)),
      'email'                  => new sfValidatorPass(array('required' => false)),
      'cellphone_number'       => new sfValidatorPass(array('required' => false)),
      'comment'                => new sfValidatorPass(array('required' => false)),
      'user_gender_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserGender'), 'column' => 'id')),
      'user_seg_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserSeg'), 'column' => 'id')),
      'address_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Address'), 'column' => 'id')),
      'user_awareness_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserAwareness'), 'column' => 'id')),
      'login_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Login'), 'column' => 'id')),
      'act_public_category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ActPublicCategory'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'name'                   => 'Text',
      'surname'                => 'Text',
      'birthdate'              => 'Date',
      'created_at'             => 'Date',
      'organization_name'      => 'Text',
      'email'                  => 'Text',
      'cellphone_number'       => 'Text',
      'comment'                => 'Text',
      'user_gender_id'         => 'ForeignKey',
      'user_seg_id'            => 'ForeignKey',
      'address_id'             => 'ForeignKey',
      'user_awareness_id'      => 'ForeignKey',
      'login_id'               => 'ForeignKey',
      'act_public_category_id' => 'ForeignKey',
    );
  }
}
