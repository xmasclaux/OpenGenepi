<?php

/**
 * Act form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ActForm extends BaseActForm
{
  public function configure()
  {
  	$subFormActType = new ActTypeForm($this->getObject()->getActType());
  	$this->embedForm('actType', $subFormActType);
  }
}
