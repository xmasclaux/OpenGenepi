<?php

/**
 * ListsFilter form base class.
 *
 * @method ListsFilter getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListsFilterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'list_id'   => new sfWidgetFormInputText(),
      'filter_id' => new sfWidgetFormInputText(),
      'ordre'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'list_id'   => new sfValidatorInteger(),
      'filter_id' => new sfValidatorInteger(),
      'ordre'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lists_filter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListsFilter';
  }

}
