<?php

/**
 * ActPublicCategory filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActPublicCategoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'designation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'  => new sfWidgetFormFilterInput(),
      'filter_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'designation' => new sfValidatorPass(array('required' => false)),
      'sort_order'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'filter_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('act_public_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ActPublicCategory';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'designation' => 'Text',
      'sort_order'  => 'Number',
      'filter_id'   => 'Number',
    );
  }
}
