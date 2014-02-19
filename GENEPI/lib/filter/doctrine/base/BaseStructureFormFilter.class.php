<?php

/**
 * Structure filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'            => new sfWidgetFormFilterInput(),
      'siret_number'     => new sfWidgetFormFilterInput(),
      'logo_path'        => new sfWidgetFormFilterInput(),
      'website'          => new sfWidgetFormFilterInput(),
      'telephone_number' => new sfWidgetFormFilterInput(),
      'address_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Address'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'email'            => new sfValidatorPass(array('required' => false)),
      'siret_number'     => new sfValidatorPass(array('required' => false)),
      'logo_path'        => new sfValidatorPass(array('required' => false)),
      'website'          => new sfValidatorPass(array('required' => false)),
      'telephone_number' => new sfValidatorPass(array('required' => false)),
      'address_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Address'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('structure_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Structure';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Text',
      'name'             => 'Text',
      'email'            => 'Text',
      'siret_number'     => 'Text',
      'logo_path'        => 'Text',
      'website'          => 'Text',
      'telephone_number' => 'Text',
      'address_id'       => 'ForeignKey',
    );
  }
}
