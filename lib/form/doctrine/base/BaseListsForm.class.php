<?php

/**
 * Lists form base class.
 *
 * @method Lists getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(),
      'type'    => new sfWidgetFormChoice(array('choices' => array('W' => 'W', 'B' => 'B'))),
      'origin'  => new sfWidgetFormChoice(array('choices' => array('SI' => 'SI', 'TO' => 'TO'))),
      'static'  => new sfWidgetFormInputText(),
      'content' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type'    => new sfValidatorChoice(array('choices' => array('W' => 'W', 'B' => 'B'), 'required' => false)),
      'origin'  => new sfValidatorChoice(array('choices' => array('SI' => 'SI', 'TO' => 'TO'), 'required' => false)),
      'static'  => new sfValidatorInteger(array('required' => false)),
      'content' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lists[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lists';
  }

}
