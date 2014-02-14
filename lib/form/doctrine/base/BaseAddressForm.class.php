<?php

/**
 * Address form base class.
 *
 * @method Address getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAddressForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'street'           => new sfWidgetFormInputText(),
      'telephone_number' => new sfWidgetFormInputText(),
      'address_city_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCity'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'street'           => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'telephone_number' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'address_city_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCity'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('address[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Address';
  }

}
