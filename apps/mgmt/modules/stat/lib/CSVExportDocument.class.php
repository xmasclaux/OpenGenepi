<?php

/**
 * Copyright 2010 Pierre Boitel, Bastien Libersa, Paul Périé
 *
 * This file is part of GENEPI.
 *
 * GENEPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * GENEPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with GENEPI. If not, see <http://www.gnu.org/licenses/>.
 */

class CSVExportDocument extends ExportDocument{
	
	public function __construct($locale){
		$this->setDocumentType(parent::CSV_FORMAT);
		parent::__construct($locale);
	}
	
	
	/**
	 * 
	 * @param unknown_type $ressoure
	 * @param unknown_type $from
	 * @param unknown_type $to
	 */
	public function export($ressource, $from, $to){
		
		switch($ressource){
			
			case parent::BALANCE_RESSOURCE:
				$this->exportBalance($from, $to);
				break;
				
			case parent::DETAILED_STATS_RESSOURCE:
				$this->exportDetailedStats($from, $to);
				break;
				
			case parent::QUANTITATIVE_STATEMENT_RESSOURCE:
				$this->exportQuantitativeStatement($from, $to);
				break;
				
			case parent::TEMPORAL_STATEMENT_RESSOURCE:
				$this->exportTemporalStatement($from, $to);
				break;
				
			default:
				break;
		}
	}
	
	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function exportBalance($from, $to){
 		
 		$this->addHeader($from, $to);
 		$this->_exportBalance($from, $to);
		$this->saveCSV('balance');	
		
 	}
 	
	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function exportDetailedStats($from, $to){
 		
 		$this->addHeader($from, $to);
 		$this->_exportDetailedStats($from, $to);
		$this->saveCSV('detailed_stats');	
		
 	}
 	
	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function exportQuantitativeStatement($from, $to){
 		
 		$this->addHeader($from, $to);
 		$this->_exportQuantitativeStatement($from, $to);
		$this->saveCSV('quantitave_statement');	
		
 	}
 	
	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function exportTemporalStatement($from, $to){
 		
 		$this->addHeader($from, $to);
 		$this->_exportTemporalStatement($from, $to);
		$this->saveCSV('temporal_statement');	
		
 	}
 	
 	
 	/**
 	 * 
 	 */
 	private function saveCSV($ressource){
 		
 		$filename = 'export_'.$ressource.'_'.date('d-m-y').'.csv';
 		
 		header('Content-Type: application/octet-stream; charset=utf-8');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->getDocument(), 'CSV');
		$objWriter->setLineEnding("\r\n");
		$objWriter->setSheetIndex(0);
		$objWriter->save('php://output'); 
 		
 	}
}