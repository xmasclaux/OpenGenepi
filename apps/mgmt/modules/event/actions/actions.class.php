<?php

/**
 * event actions.
 *
 * @package    GENEPI
 * @subpackage event
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
}
