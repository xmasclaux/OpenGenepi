<?php

/**
 * Login filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLoginFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'login'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_moderator' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'locked'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'login'        => new sfValidatorPass(array('required' => false)),
      'password'     => new sfValidatorPass(array('required' => false)),
      'is_moderator' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'locked'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('login_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Login';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'login'        => 'Text',
      'password'     => 'Text',
      'is_moderator' => 'Number',
      'locked'       => 'Number',
    );
  }
}
