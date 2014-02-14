<?php

/**
 * Moderator filter form base class.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseModeratorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'surname'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'login_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Login'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'     => new sfValidatorPass(array('required' => false)),
      'surname'  => new sfValidatorPass(array('required' => false)),
      'email'    => new sfValidatorPass(array('required' => false)),
      'login_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Login'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('moderator_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Moderator';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'name'     => 'Text',
      'surname'  => 'Text',
      'email'    => 'Text',
      'login_id' => 'ForeignKey',
    );
  }
}
