<?php

/**
 * ActPrice form base class.
 *
 * @method ActPrice getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseActPriceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'act_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Act'), 'add_empty' => false)),
      'act_public_category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActPublicCategory'), 'add_empty' => false)),
      'value'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'act_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Act'))),
      'act_public_category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ActPublicCategory'))),
      'value'                  => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('act_price[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ActPrice';
  }

}
