<?php

/**
 * Computer form base class.
 *
 * @method Computer getObject() Returns the current form's model object
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseComputerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'name'                          => new sfWidgetFormInputText(),
      'shortened_name'                => new sfWidgetFormInputText(),
      'comment'                       => new sfWidgetFormInputText(),
      'year'                          => new sfWidgetFormInputText(),
      'mac_address'                   => new sfWidgetFormInputText(),
      'ip_address'                    => new sfWidgetFormInputText(),
      'room_id'                       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'add_empty' => true)),
      'computer_machine_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerMachineType'), 'add_empty' => false)),
      'computer_os_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerOs'), 'add_empty' => true)),
      'computer_type_of_connexion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerTypeOfConnexion'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'                          => new sfValidatorString(array('max_length' => 45)),
      'shortened_name'                => new sfValidatorString(array('max_length' => 20)),
      'comment'                       => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'year'                          => new sfValidatorInteger(array('required' => false)),
      'mac_address'                   => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'ip_address'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'room_id'                       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Room'), 'required' => false)),
      'computer_machine_type_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerMachineType'))),
      'computer_os_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerOs'), 'required' => false)),
      'computer_type_of_connexion_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ComputerTypeOfConnexion'))),
    ));

    $this->widgetSchema->setNameFormat('computer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Computer';
  }

}
