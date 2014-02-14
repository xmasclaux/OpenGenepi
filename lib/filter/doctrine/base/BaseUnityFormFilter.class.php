<?php

/**
 * Unity filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUnityFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'shortened_designation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'disabled'              => new sfWidgetFormFilterInput(),
      'sort_order'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'designation'           => new sfValidatorPass(array('required' => false)),
      'shortened_designation' => new sfValidatorPass(array('required' => false)),
      'disabled'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sort_order'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('unity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Unity';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'designation'           => 'Text',
      'shortened_designation' => 'Text',
      'disabled'              => 'Number',
      'sort_order'            => 'Number',
    );
  }
}
