<?php

/**
 * UserGender filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserGenderFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'designation' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_gender_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserGender';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'designation' => 'Text',
    );
  }
}
