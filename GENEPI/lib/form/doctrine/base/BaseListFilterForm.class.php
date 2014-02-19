<?php

/**
 * Listfilter form base class.
 *
 * @method Listfilter getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseListfilterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'list_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lists'), 'add_empty' => false)),
      'filter_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Filter'), 'add_empty' => false)),
      'order'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'list_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Lists'))),
      'filter_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Filter'))),
      'order'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('listfilter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Listfilter';
  }

}
