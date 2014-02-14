<?php

/**
 * ActPrice filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActPriceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'act_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'add_empty' => true)),
      'act_public_category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActPublicCategory'), 'add_empty' => true)),
      'value'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'act_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Act'), 'column' => 'id')),
      'act_public_category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ActPublicCategory'), 'column' => 'id')),
      'value'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('act_price_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ActPrice';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'act_id'                 => 'ForeignKey',
      'act_public_category_id' => 'ForeignKey',
      'value'                  => 'Number',
    );
  }
}
