<?php

/**
 * Filter form.
 *
 * @package    GENEPI
 * @subpackage form
 * @author     Pierre Boitel, Bastien Libersa, Paul Périé
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FilterForm extends BaseFilterForm
{
	
	public function configure()
	{
		unset(
				$this["id"]
		);
			
		$this->setWidgets(array(
				'name'    => new sfWidgetFormInput(),
				'description'   => new sfWidgetFormInput(),
		));
		
		$this->widgetSchema->setLabels(array(
				'name'    => 'Name',
				'description'   => 'description',
		));
	}
	
}