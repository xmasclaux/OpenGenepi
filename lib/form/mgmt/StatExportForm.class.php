<?php

/**
 * Statistics Export form.
 *
 * @package    epi
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class StatExportForm extends sfForm{
	
	public function setup(){
		
		$formats = array(
				'csv' => 'CSV (Comma Separated Values)',
				'pdf' => 'PDF (Portable Document Format)',
				'xls' => 'XLS (Microsoft Excel 2003)',
				'ods' => 'ODS (Open Document Spreadsheet)');
		
		$exportable = array(
				'ressource_detailed_stat'          => 'Detailed statistics',
				'ressource_quantitative_statement' => 'Quantitative statement',
				'ressource_temporal_statement'     => 'Temporal statement',
				'ressource_balance'                => 'Balance');
		
		/*----------------------------------WIDGETS----------------------------------------------*/
		
	  	$this->setWidgets(array(
	  		'ressource'  => new sfWidgetFormSelectRadio(array('choices' => $exportable)),
	   		'format'     => new sfWidgetFormSelectRadio(array('choices' => $formats)),
	  		'from'		 => new sfWidgetFormInputHidden(),
	  		'to'		 => new sfWidgetFormInputHidden(),
	    ));
		
	    $this->widgetSchema->setLabels(array(
	    	'ressource'  => 'Choose the ressource to export',
	   		'format'     => 'Choose the format to export',
	    ));
	    
	    /*-----------------------------------VALIDATORS-------------------------------------------*/
	    
	    $this->setValidators(array(
	    	'ressource'  => new sfValidatorChoice(array('choices' => $exportable)),
	   		'format'     => new sfValidatorChoice(array('choices' => $formats)),	
	    	'from'		 => new sfValidatorDate(),
	  		'to'		 => new sfValidatorDate(),
	    ));
	    
	    
	    $this->widgetSchema->setNameFormat('stat_export[%s]');
	    
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	}
}