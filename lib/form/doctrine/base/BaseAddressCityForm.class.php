<?php

/**
 * AddressCity form base class.
 *
 * @method AddressCity getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAddressCityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'postal_code'        => new sfWidgetFormInputText(),
      'insee_code'         => new sfWidgetFormInputText(),
      'address_country_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCountry'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 90, 'required' => false)),
      'postal_code'        => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'insee_code'         => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'address_country_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AddressCountry'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('address_city[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AddressCity';
  }

}
