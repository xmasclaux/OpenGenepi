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

 class ExportDocument{
 	
 	const CSV_FORMAT = 'csv';
 	
 	const PDF_FORMAT = 'pdf';
 	
 	const XLS_FORMAT = 'xls';
 	
 	const ODS_FORMAT = 'ods';
 	
 	const BALANCE_RESSOURCE = 'ressource_balance';
 	
 	const DETAILED_STATS_RESSOURCE = 'ressource_detailed_stat';
 	
 	const QUANTITATIVE_STATEMENT_RESSOURCE = 'ressource_quantitative_statement';
 	
 	const TEMPORAL_STATEMENT_RESSOURCE = 'ressource_temporal_statement';
 	
 	
 	/*Translations:*/
 	const BALANCE_PER_ACT = 'Balance per act';
 	const ACTS = 'Acts';
 	const VALUE = 'Value';
 	const PERCENTAGE = 'Percentage';
 	const TIME = 'Time';
 	const TOTAL = 'Total';
 	const ACCOUNTS_STATUS = 'Accounts status';
 	const MONETARY_ACCOUNTS = 'Monetary accounts';
 	const NUMBER_OF_ACCOUNTS = 'Number of accounts';
 	const BALANCE_PER_METHOD_OF_PAYMENT = 'Balance per method of payment';
 	const METHODS_OF_PAYMENTS = 'Methods of payment';
 	const POSITIVES = 'Positives';
 	const NEGATIVES = 'Negatives';
 	const PERIOD = 'Period';
 	const FROM_DATE = 'From';
 	const TO_DATE = 'to';
 	const AT = 'at';
 	const GENERATED = 'Generated';
 	const DATE_FORMAT = 'm/d/y';
 	const GENDER = 'Gender';
 	const MALE = 'Male';
 	const FEMALE = 'Female';
 	const NUMBER_OF_USES = 'Total of uses (with a duration or not)';
 	const AGE_RANGE = 'Age range';
 	const COUNTRY_CITY = 'Country/city';
 	const DAY_TIME_SLOT = 'Day/time slot';
 	const PUBLIC_CATEGORY = 'Public category';
 	const ACT = 'Act';
 	const SEG = 'SEG';
 	const BUILDING_ROOM_COMPUTER = 'Building/room/computer';
 	const TYPE_OF_CONNECTION = 'Type of connection';
 	const WAY_OF_AWARENESS = 'Way of awareness';
 	const MONDAY = 'Monday';
 	const TUESDAY = 'Tuesday';
 	const WEDNESDAY = 'Wednesday';
 	const THURSDAY = 'Thursday';
 	const FRIDAY = 'Friday';
 	const SATURDAY = 'Saturday';
 	const SUNDAY = 'Sunday';
 	const OTHER = 'Other';
 	const DETAILED_STATS = 'Detailed statistics';
 	const BY_GENDER = 'By gender';
 	const BY_AGE_RANGE = 'By age range';
 	const BY_COUNTRY_CITY = 'By country/city';
 	const BY_DAY_TIME = 'By day/time slot';
 	const BY_PUBLIC_CATEGORY = 'By category';
 	const BY_ACT = 'By act';
 	const BY_SEG = 'By SEG';
 	const BY_BUILDING = 'By building/room/computer';
 	const BY_CONNECTION = 'By type of connection';
 	const BY_AWARENESS = 'By awareness';
 	const CRITERIAS = 'Criterias';
 	const GLOBAL_DATA = 'Global Data';
 	const TOTAL_OF_USES = 'Total of uses';
 	const NUMBER_UNIQUE_VISITORS = 'Number of unique visitors';
 	const NUMBER_REGULAR_VISITORS = 'Number of regular visitors';
 	const INF_10 = 'inferior to 10';
 	const BET_11_20 = '11 to 20';
 	const BET_21_30 = '21 to 30';
 	const BET_31_40 = '31 to 40';
 	const BET_41_50 = '41 to 50';
 	const BET_51_60 = '51 to 60';
 	const BET_61_70 = '61 to 70';
 	const BET_71_80 = '71 to 80';
 	const SUP_80 = 'superior to 80';
 	const NO_CATEGORY = 'No category';
 	const NOT_AVAILABLE = 'Not available';
 	const TOTAL_TIME = 'Total time';
 	const TOTAL_TIME_UNIQUE = 'Total time of unique visitors';
 	const DETAILS_TIME_SLOT = 'Details per time slots';
 	const DETAILS_CATEGORIES = 'Details per categories';
 	const CHEQUE = 'Cheque';
 	const CASH = 'Cash';
 	const ACCOUNT = 'Account';
 	const IN_KIND = 'In kind';
 	const FREE = 'Free';
 	
 	
 	/**
 	 * 
 	 * @var unknown_type
 	 */
 	private $_translations = array(
 		'fr' => array(
 				self::BALANCE_PER_ACT               => 'Caisse par acte',
 				self::ACTS                          => 'Actes',
 				self::VALUE                         => 'Valeur',
 				self::PERCENTAGE                    => 'Pourcentage',
 				self::TIME                          => 'Temps',
 				self::TOTAL                         => 'Total',
 				self::ACCOUNTS_STATUS               => 'Etat des comptes',
 				'Monetary accounts'                 => 'Comptes monétaires',
 				self::NUMBER_OF_ACCOUNTS            => 'Nombre de comptes',
 				self::BALANCE_PER_METHOD_OF_PAYMENT => 'Caisse par méthode de paiement',
 				self::METHODS_OF_PAYMENTS           => 'Méthodes de paiement',
 				self::POSITIVES                     => 'Positifs',
 				self::NEGATIVES                     => 'Négatifs',
 				self::PERIOD                        => 'Période',
 				self::FROM_DATE                     => 'Du',
 				self::TO_DATE                       => 'au',
 				self::AT                            => 'à',
 				self::GENERATED                     => 'Généré',
 				self::DATE_FORMAT                   => 'd/m/y',
 				self::GENDER                        => 'Sexe',
 				self::MALE                          => 'Homme',
 				self::FEMALE                        => 'Femme',
 				'Total of uses (with a duration or not)'               => 'Total des usages (avec une durée ou non)',
 				self::AGE_RANGE                     => 'Tranche d\'âge',
 				self::COUNTRY_CITY                  => 'Pays/ville',
 				self::DAY_TIME_SLOT                 => 'Jour/heure',
 				self::PUBLIC_CATEGORY               => 'Catégorie de public',
 				self::ACT                           => 'Acte',
 				self::SEG                           => 'CSP',
 				self::BUILDING_ROOM_COMPUTER        => 'Batiment/salle/ordinateur',
 				self::TYPE_OF_CONNECTION            => 'Type de connexion',
 				self::WAY_OF_AWARENESS              => 'Moyen de connaissance',
 				self::MONDAY                        => 'Lundi',
 				self::TUESDAY                       => 'Mardi',
 				self::WEDNESDAY                     => 'Mercredi',
 				self::THURSDAY                      => 'Jeudi',
 				self::FRIDAY                        => 'Vendredi',
 				self::SATURDAY                      => 'Samedi',
 				self::SUNDAY                        => 'Dimanche',
 				self::OTHER                         => 'Autre',
 				self::DETAILED_STATS                => 'Statistiques détaillées',
 				'By gender'                         => 'Par sexe',
 				'By age range'                      => 'Par tranche d\'âge',
 				'By country/city'                   => 'Par pays/ville',
 				'By day/time slot'                  => 'Par jour/heure',
 				'By category'                       => 'Par catégorie de public',
 				'By act'                            => 'Par acte',
 				'By SEG'                            => 'Par CSP',
 				'By building/room/computer'         => 'Par batiment/salle/ordinateur',
 				'By type of connection'             => 'Par type de connexion',
 				'By awareness'                      => 'Par moyen de connaissance',
 				self::CRITERIAS                     => 'Critères',
 				self::GLOBAL_DATA                   => 'Données globales',
 				self::INF_10                        => 'inférieur à 10',
 				self::BET_11_20                     => '11 à 20',
 				self::BET_21_30                     => '21 à 30',
 				self::BET_31_40                     => '31 à 40',
 				self::BET_41_50                     => '41 à 50',
 				self::BET_51_60                     => '51 à 60',
 				self::BET_61_70                     => '61 à 70',
 				self::BET_71_80                     => '71 à 80',
 				self::SUP_80                        => 'supérieur à 80',
 				self::TOTAL_OF_USES                 => 'Total des usages',
 				self::NUMBER_UNIQUE_VISITORS        => 'Nombre de visiteurs uniques',
 				self::NUMBER_REGULAR_VISITORS       => 'Nombre de visiteurs réguliers',
 				self::NO_CATEGORY                   => 'Pas de catégorie',
 				self::NOT_AVAILABLE                 => 'Non renseigné',
 				self::TOTAL_TIME                    => 'Temps total',
 				self::TOTAL_TIME_UNIQUE             => 'Temps total des visiteurs uniques',
 				self::DETAILS_TIME_SLOT             => 'Détail par heure',
 				self::DETAILS_CATEGORIES            => 'Détail par catégorie',
 				self::CHEQUE                        => 'Chèque',
 				self::CASH                          => 'Liquide',
 				self::ACCOUNT                       => 'Compte',
 				self::IN_KIND                       => 'En nature',
 				self::FREE                          => 'Gratuit',
 				'Belgium'                         	=> 'Belgique',
 				'United Kingdom'                    => 'Royaume-Uni',
 				'Italy'                    			=> 'Italie',
 				'Spain'                    			=> 'Espagne',
 				'Germany'                    		=> 'Allemagne',),
 				
 	);
 	
 	/**
 	 * 
 	 * @var unknown_type
 	 */
 	private $_locale;
 	 	
 	/**
 	 * 
 	 * @var unknown_type
 	 */
 	private $document;
 	
 	/**
 	 * 
 	 * @var unknown_type
 	 */
 	private $document_type;
 	
 	
 	/**
 	 * 
 	 * @var unknown_type
 	 */
 	private $_row;
 	
 	
 	/**
 	 * 
 	 */
 	public function __construct($locale){
 		
 		//Create the new instance of the document:
 		$this->setDocument(new sfPHPExcel());

 		PHPExcel_Settings::setLocale($locale);
 		
 		$this->_locale = $locale;
 	}
 	
 	/**
 	 * 
 	 */
 	public function getDocument(){
 		return $this->document;
 	}
 	
 	/**
 	 * 
 	 * @param unknown_type $doc
 	 */
 	public function setDocument($doc){
 		$this->document = $doc;
 	}
 	
 	/**
 	 * 
 	 */
 	public function getDocumentType(){
 		return $this->document_type;
 	}
 	
 	/**
 	 * 
 	 * @param unknown_type $doc
 	 */
 	public function setDocumentType($doc_type){
 		$this->document_type = $doc_type;
 	}
 	
 	/**
 	 * 
 	 * @param unknown_type $jump
 	 */
 	private function nextLine($jump = 1){
 		$this->_row += $jump;
 	}
 	
 	
 	
 	private function _translate($string){
 		
 		if($this->_locale == 'en'){
 			return $string;
 		}else{
 			if(in_array($this->_locale, array_keys($this->_translations))){
 				if(in_array($string, array_keys($this->_translations[$this->_locale]))){
 					return $this->_translations[$this->_locale][$string];
 				}else{
 					return $string;
 				}
 			}else{
 				return $string;
 			}
 		}
 	}
 	
  	
 	/**
 	 * 
 	 * @param unknown_type $format
 	 */
 	public static function instanciateDocument($format, $locale){
 		
 		$instance = null;
 		
 		switch($format){
 			
 			case self::CSV_FORMAT:
 				$instance = new CSVExportDocument($locale);
 				break;
 				
 			case self::PDF_FORMAT:
 				$instance = new PDFExportDocument($locale);
 				break;
 				
 			case self::XLS_FORMAT:
 				$instance = new XLSExportDocument($locale);
 				break;
 				
 			case self::ODS_FORMAT:
 				$instance = new ODSExportDocument($locale);
 				break;
 				
 			default:
 				break;
 		}
 		
 		return $instance;
 	}
 	
 	protected function addHeader($from, $to){
 		
 		$this->_row = 1;
 		
 		$structure = Doctrine::getTable('Structure')
 				->createQuery('a')
      			->fetchOne();
 		
 		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder());
	
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		//Add the logo of the structure at the top left of the page:
 		$logo = new PHPExcel_Worksheet_Drawing();
		$logo->setName('Logo');
		$logo->setDescription('Logo');
		$logo->setPath('./uploads/images/logo.png');
		$logo->setHeight(60);
		$logo->setWidth(129);
		$logo->setCoordinates('A'.$this->_row);

		$logo->setWorksheet($active_sheet);
		
		//Merge the cells at the top right of the page:
		$active_sheet->mergeCells('B'.$this->_row.':D'.$this->_row);
		
		//and put inside the informations about the structure:
		$active_sheet->getCell('B'.$this->_row)->setValue(
				$structure->getName()."\n".
				$structure->getAddress()->getStreet()."\n".
				$structure->getAddress()->getAddressCity()->getPostalCode()." ".$structure->getAddress()->getAddressCity()->getName()."\n".
				"Tel: ".$structure->getTelephoneNumber()."\n".
				"Tel2: ".$structure->getAddress()->getTelephoneNumber()."\n".
				"e-mail: ".$structure->getEmail()."\n".
				"site: ".$structure->getWebsite()."\n"
				);
				
		$active_sheet->getStyle('B'.$this->_row)->getFont()->setBold(true);
		
		$this->nextLine();
		
		//Write the chosen period at the date of document generation:
		$active_sheet->getCell('A'.$this->_row)->setValue(($this->_translate("Period").":\n".$this->_translate("From")." ".date($this->_translate('m/d/y'),strtotime($from))." ".$this->_translate("to")." ".date($this->_translate('m/d/y'),strtotime($to))));
		$active_sheet->getCell('B'.$this->_row)->setValue($this->_translate("Generated").":\n".date($this->_translate('m/d/y'))." ".$this->_translate("at")." ".date('H:i:s'));
		
		$active_sheet->getStyle('A'.$this->_row.':B'.$this->_row)->getFont()->setSize(8);
		
		
		//General specifications of the page:
		
		//Footer:
		$active_sheet->getHeaderFooter()->setOddFooter('&L&D&RPage &P/&N');
		
		$this->nextLine(2);
 	}
 	
 	
 	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function _exportBalance($from, $to){
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* ------------------------------ BALANCE PER ACT ------------------------------ */
 		$this->_exportBalancePerAct($from, $to);
 		
 		$this->nextLine(3);

 		/* ------------------------------ ACCOUNTS STATUS ------------------------------ */
 		$this->_exportBalanceAccountStatus($from, $to);
 		
	  	$this->nextLine(3);

 		/* ------------------------ BALANCE PER METHOD OF PAYMENT ---------------------- */
	  	$this->_exportBalancePerMop($from, $to);
 		
 		$this->nextLine();
 
 		/* ------------------------------------ STYLE -----------------------------------*/
 		$active_sheet->getColumnDimension('A')->setAutoSize(true);
 		$active_sheet->getColumnDimension('B')->setAutoSize(true);
 		$active_sheet->getColumnDimension('C')->setWidth(25);
 		$active_sheet->getColumnDimension('D')->setWidth(8);

 		$page_setup = new PHPExcel_Worksheet_PageSetup();
 		$page_setup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 		$page_setup->setFitToPage(true);
 		$page_setup->setFitToWidth(1);
 		$page_setup->setFitToHeight(0);
 		$page_setup->setHorizontalCentered(true);
 		$page_setup->setPrintArea('A1:D'.$this->_row);
 		
 		$active_sheet->setPageSetup($page_setup);
 		$active_sheet->setShowGridlines(false);
 		$active_sheet->setPrintGridlines(false);
 		
 		//Margins:
		$active_sheet->getPageMargins()->setTop(0.60);
		$active_sheet->getPageMargins()->setRight(0.40);
		$active_sheet->getPageMargins()->setLeft(0.40);
		$active_sheet->getPageMargins()->setBottom(0.70);
 	}
 	
 	
 	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function _exportDetailedStats($from, $to){
 		
 		/* --------------------- EXPORTATION OF THE DETAILED STATS ------------------------ */
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* ---------------------------------- BY GENDER ----------------------------------- */
 		
 		$imputationsGlobal = Doctrine_Query::create()
		    ->select('COUNT(*) as number, SUM(TIME_TO_SEC(i.duration)) as duration')
		    ->from('ImputationArchive i')
	  		->where('i.imputation_date BETWEEN ? AND ?',array($from,$to))
	  		->fetchOne();
	  		
	  	$numberImputations = $imputationsGlobal->getNumber();
	  	$totalDuration = $imputationsGlobal->getDuration();
	  	
	  	$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::DETAILED_STATS));
	  	
	  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 				
 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
 		
 		$this->nextLine(2);
 		
 		/* --------------------------------- BY GENDER ---------------------------------- */
	  	
	  	$this->_exportDetailedValuesByGender($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* --------------------------------- BY AGE RANGE ---------------------------------- */
	  	
	  	$this->_exportDetailedValuesByAgeRange($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ------------------------------ BY COUNTRY AND CITY ------------------------------ */
	  	
	  	$this->_exportDetailedValuesByCountryAndCity($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY DAY AND TIME ------------------------------ */
	  	
	  	$this->_exportDetailedValuesByDay($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY PUBLIC CATEGORY ------------------------------ */
	  	
	  	$this->_exportDetailedValuesByPublicCategory($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY PUBLIC CATEGORY ------------------------------ */
	  	
	  	$this->_exportDetailedValuesByAct($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY PUBLIC CATEGORY ------------------------------ */
	  	
	  	$this->_exportDetailedValuesBySeg($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY PUBLIC CATEGORY ------------------------------ */

	  	$this->_exportDetailedValuesByBuilding($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY PUBLIC CATEGORY ------------------------------ */
	  	
	  	$this->_exportDetailedValuesByTypeOfConnection($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	/* ---------------------------------- BY PUBLIC CATEGORY ------------------------------ */
	  	
	  	$this->_exportDetailedValuesByAwareness($from, $to, $numberImputations, $totalDuration);
	  	
	  	$this->nextLine(3);
	  	
	  	$active_sheet->getColumnDimension('A')->setWidth(30);
 		$active_sheet->getColumnDimension('B')->setAutoSize(true);
 		$active_sheet->getColumnDimension('C')->setWidth(25);
 		$active_sheet->getColumnDimension('D')->setWidth(8);

 		$page_setup = new PHPExcel_Worksheet_PageSetup();
 		$page_setup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 		$page_setup->setFitToPage(true);
 		$page_setup->setFitToWidth(1);
 		$page_setup->setFitToHeight(0);
 		$page_setup->setHorizontalCentered(true);
 		$page_setup->setPrintArea('A1:D'.$this->_row);
 		
 		$active_sheet->setPageSetup($page_setup);
 		$active_sheet->setShowGridlines(false);
 		$active_sheet->setPrintGridlines(false);
 		
 		//Margins:
		$active_sheet->getPageMargins()->setTop(0.60);
		$active_sheet->getPageMargins()->setRight(0.40);
		$active_sheet->getPageMargins()->setLeft(0.40);
		$active_sheet->getPageMargins()->setBottom(0.70);
 	}
 	
 	
 	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function _exportQuantitativeStatement($from, $to){
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		
 		$acts = Doctrine_Query::create()
			->select('a.designation')
			->from('Act a')
			->where('a.disabled = ?', 0)
			->orderBy('a.designation')
			->execute();
			
		$numberOfActs = Doctrine_Query::create()
		    ->select('COUNT(*) as total')
		    ->from('Act a')
			->where('a.disabled = ?', 0)
	  		->fetchOne();
	  	
		$statement = Statistics::getQuantitativeStatementValuesByAct($from, $to);
		
		/*Print all the acts at the top:*/
		$this->_exportQuantitativeStatementHeader($statement);
		
		$columns = Statistics::getQuantitativeStatementColumns($from,$to);
		$total = Statistics::getTotalQuantitativeStatementValues($from,$to);
		
 		
		foreach($columns as $stat_type => $stat){
			$this->_exportQuantitativeStatementRessourceByString($columns, $statement, $stat_type, $total);
		}
		
 		foreach($columns as $stat_type => $stat){
			$this->_exportQuantitativeStatementRessourceById($columns, $statement, $stat_type, $total);
		}
		
		//Specific exportations:
		$this->_exportQuantitativeStatementByCountry($columns, $statement, $total, $from, $to);
		$this->nextLine(3);
		
		$this->_exportQuantitativeStatementByDay($columns, $statement, $total);
		$this->nextLine(3);
		
		$this->_exportQuantitativeStatementByBuilding($columns, $statement, $total);
		$this->nextLine(3);
		
		//Details per category:
		$detailsPerCategory = Statistics::getQuantitativeDetailsPerCategory($from, $to);
		$this->_exportDetailsPerCategory($columns, $detailsPerCategory, $total);
		$this->nextLine(3);
		
		//Details per time slot:
		$detailsPerTimeSlot = Statistics::getQuantitativeDetailsPerTimeSlot($from, $to);
		$this->_exportDetailsPerTimeSlot($columns, $detailsPerTimeSlot, $total);
		$this->nextLine(3);
		
		//Page setup:
		$page_setup = new PHPExcel_Worksheet_PageSetup();
 		$page_setup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 		$page_setup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
 		$page_setup->setHorizontalCentered(true);
 		
 		
 		$active_sheet->setPageSetup($page_setup);
 		$active_sheet->setShowGridlines(true);
 		$active_sheet->setPrintGridlines(true);
 		
 		//Margins:
		$active_sheet->getPageMargins()->setTop(0.40);
		$active_sheet->getPageMargins()->setRight(0.20);
		$active_sheet->getPageMargins()->setLeft(0.20);
		$active_sheet->getPageMargins()->setBottom(0.40);
 	}
 	
 	
 	/**
 	 * 
 	 * @param $from
 	 * @param $to
 	 */
 	protected function _exportTemporalStatement($from, $to){
 		
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		
 		$acts = Doctrine_Query::create()
			->select('a.designation')
			->from('Act a')
			->where('a.disabled = ?', 0)
			->orderBy('a.designation')
			->execute();
			
		$numberOfActs = Doctrine_Query::create()
		    ->select('COUNT(*) as total')
		    ->from('Act a')
			->where('a.disabled = ?', 0)
	  		->fetchOne();
	  	
		$statement = Statistics::getTemporalStatementValuesByAct($from, $to);
		//Format the statement data into times:
		$statement = self::formatStatement($statement);
		
		/*Print all the acts at the top:*/
		$this->_exportQuantitativeStatementHeader($statement);
		
		$columns = Statistics::getTemporalStatementColumns($from, $to);
		
		$total = Statistics::getTotalTemporalStatementValues($from,$to);
		//Format the total data into times:
		$total = self::formatTotal($total);
		
 		
 		foreach($columns as $stat_type => $stat){
			$this->_exportQuantitativeStatementRessourceByString($columns, $statement, $stat_type, $total);
		}
		
 		foreach($columns as $stat_type => $stat){
			$this->_exportQuantitativeStatementRessourceById($columns, $statement, $stat_type, $total);
		}
		
		//Specific exportations:
		$this->_exportQuantitativeStatementByCountry($columns, $statement, $total, $from, $to);
		$this->nextLine(3);
		
		$this->_exportQuantitativeStatementByDay($columns, $statement, $total);
		$this->nextLine(3);
		
		$this->_exportQuantitativeStatementByBuilding($columns, $statement, $total);
		$this->nextLine(3);
		
		//Details per category:
		$detailsPerCategory = Statistics::getTemporalDetailsPerCategory($from, $to, $total);
		$detailsPerCategory = self::formatStatement($detailsPerCategory);
		$this->_exportDetailsPerCategory($columns, $detailsPerCategory, $total);
		$this->nextLine(3);
		
		//Details per time slot:
		$detailsPerTimeSlot = Statistics::getTemporalDetailsPerTimeSlot($from, $to, $total);
		$detailsPerTimeSlot = self::formatStatement($detailsPerTimeSlot);
		$this->_exportDetailsPerTimeSlot($columns, $detailsPerTimeSlot, $total);
		$this->nextLine(3);
		
		
		//Page setup:
		$page_setup = new PHPExcel_Worksheet_PageSetup();
 		$page_setup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 		$page_setup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
 		$page_setup->setHorizontalCentered(true);
 		
 		
 		$active_sheet->setPageSetup($page_setup);
 		$active_sheet->setShowGridlines(true);
 		$active_sheet->setPrintGridlines(true);
 		
 		//Margins:
		$active_sheet->getPageMargins()->setTop(0.40);
		$active_sheet->getPageMargins()->setRight(0.20);
		$active_sheet->getPageMargins()->setLeft(0.20);
		$active_sheet->getPageMargins()->setBottom(0.40);
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 */
 	private function _exportBalancePerAct($from, $to){
 		
 		$begin_row = $this->_row;
 		
 		/* ------------------- EXPORTATION OF THE BALANCE PER ACT --------------------------*/
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		$act_values = Statistics::getValuesByAct($from, $to);
 		
 			/*------------------------------ TITLE -----------------------------*/
		
			$active_sheet->getCell('A'.$this->_row)->setValue($this->_translate('Balance per act'));
	
	 		$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
	 		
	 		/*----------------------------- END TITLE ---------------------------*/
 				
 		$this->nextLine();
 		
 			/*------------------------------ HEADER -----------------------------*/
 		 				
	 		$active_sheet->getCellByColumnAndRow(0, $this->_row)->setValue($this->_translate('Acts'));
	 		$active_sheet->getCellByColumnAndRow(1, $this->_row)->setValue($this->_translate('Value'));
	 		$active_sheet->getCellByColumnAndRow(2, $this->_row)->setValue($this->_translate('Percentage'));
	 		$active_sheet->getCellByColumnAndRow(3, $this->_row)->setValue($this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		
	 		/*----------------------------- END HEADER ---------------------------*/
 		
 		$this->nextLine();
 		
 			/*------------------------------ BODY -----------------------------*/
 		
	 		foreach($act_values['act'] as $act_designation => $act_value_percentage){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $act_designation);
		 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $act_value_percentage['value']);
		 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $act_value_percentage['percentage'].'%');
		 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $act_value_percentage['time']).'h'.gmdate('i', $act_value_percentage['time']));
		 		
		 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
		 		$this->nextLine();
	 		}
	 		/*----------------------------- END BODY ---------------------------*/
	 		
	 		/*------------------------------ FOOTER -----------------------------*/
	 		
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $act_values['total_value']);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $act_values['total_time']).'h'.gmdate('i', $act_values['total_time']));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 				
	 		/*----------------------------- END FOOTER ---------------------------*/
 		
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 */
 	private function _exportBalanceAccountStatus($from, $to){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* ------------------- EXPORTATION OF THE ACCOUNTS STATUS --------------------------*/
 		
 		
 		$positive_accounts = Statistics::getPositiveAccounts();
	  	$negative_accounts = Statistics::getNegativeAccounts();
	  	$total_accounts['value'] = $positive_accounts['value'] + $negative_accounts['value'];
	  	$total_accounts['number'] = $positive_accounts['number'] + $negative_accounts['number'];
	  	
		  	/*------------------------------ TITLE -----------------------------*/
		  	
		  	$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Accounts status'));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':C'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
	  		/*----------------------------- END TITLE ---------------------------*/
	  		
 		$this->nextLine();
 		
 			/*------------------------------ HEADER -----------------------------*/

	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Monetary accounts'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Value'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Number of accounts'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':C'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 		
 			/*----------------------------- END HEADER ---------------------------*/
 				
 		$this->nextLine();
 		
 			/*------------------------------ BODY -----------------------------*/
 		
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Positives'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $positive_accounts['value']);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $positive_accounts['number']);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	 		$this->nextLine();
	 		
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Negatives'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $negative_accounts['value']);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $negative_accounts['number']);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 				
 			/*----------------------------- END BODY ---------------------------*/
 		
 		$this->nextLine();
 		
 			/*------------------------------ FOOTER -----------------------------*/
 		
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $total_accounts['value']);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $total_accounts['number']);
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':C'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':C'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 				
	 		/*----------------------------- END FOOTER ---------------------------*/
	 				
	 	$active_sheet->getStyle('A'.($begin_row+1).':C'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 */
 	private function _exportBalancePerMop($from, $to){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE BALANCE PER METHOD OF PAYMENT -----------------*/
 		
 		$methods_of_payments_values = Statistics::getTotalValuesByMethodOfPayment($from, $to);
 		
 			/*------------------------------ TITLE -----------------------------*/
	  	
		  	$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Balance per method of payment'));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':C'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
	 		/*----------------------------- END TITLE ---------------------------*/
	  	
 		$this->nextLine();
 		
 			/*------------------------------ HEADER -----------------------------*/
	  	
		  	$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Methods of payment'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Value'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':C'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 		
 			/*----------------------------- END HEADER ---------------------------*/
 		
 		$this->nextLine();
 		
 			/*------------------------------ BODY -----------------------------*/
	  	
		  	foreach($methods_of_payments_values['mop'] as $mop_designation => $mop_value_percentage){
		  		
		  		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate($mop_designation));
		 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $mop_value_percentage['value']);
		 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $mop_value_percentage['percentage'].'%');
		 		
		 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 		
	 			$this->nextLine();
		  	}
	  		/*----------------------------- END BODY ---------------------------*/
		  	
		  	/*------------------------------ FOOTER -----------------------------*/
	  	
		  	$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $methods_of_payments_values['total_value']);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':C'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':C'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':C'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
 				
 			/*----------------------------- END FOOTER ---------------------------*/

	 	$active_sheet->getStyle('A'.($begin_row+1).':C'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 				
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $begin_date
 	 * @param unknown_type $end_date
 	 * @param unknown_type $numberImputations
 	 */
 	private function _exportDetailedValuesByGender($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY GENDER -----------------*/
 		
 		$genderStats = Statistics::getDetailedValuesByGender($from, $to, $numberImputations);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_GENDER));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Gender'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Male'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $genderStats["male"][0]);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $genderStats["male"][1].' %');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $genderStats["male"][2]).'h'.gmdate('i', $genderStats["male"][2]));
			
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		
	 		$this->nextLine();	
	 		
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Female'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $genderStats["female"][0]);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $genderStats["female"][1].' %');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $genderStats["female"][2]).'h'.gmdate('i', $genderStats["male"][2]));
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalTime
 	 */
 	private function _exportDetailedValuesByAgeRange($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY AGE RANGE -----------------*/
 		
 		$ageRangeStats = Statistics::getDetailedValuesByAgeRange($from, $to, $numberImputations);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_AGE_RANGE));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Age range'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($ageRangeStats as $ageRangeStat){
	 			$ageRangeStat[0] = str_replace('<=','< =',$ageRangeStat[0]);
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $ageRangeStat[0]);
	 			$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $ageRangeStat[1]);
		 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $ageRangeStat[2].' %');
		 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $ageRangeStat[3]).'h'.gmdate('i', $ageRangeStat[3]));
				
		 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
		 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 		
		 		$this->nextLine();
	 			
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 		
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByCountryAndCity($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY AGE RANGE -----------------*/
 		$countries = array();
 		$cities = array();
 		$citiesTable = array();
 		
 		$imputations = Doctrine_Query::create()
		    ->select('i.*')
		    ->from('ImputationArchive i')
	  		->where('imputation_date BETWEEN ? AND ?',array($from, $to))
	  		->execute();
 		
 		foreach($imputations as $imputation)
	  	{
	  		$country = $imputation->getUserArchive()->getCountry();
	  		$city = $imputation->getUserArchive()->getCityName();
		  	if(!in_array($country, $countries)) $countries[] = $country;
		  	if(!in_array($city, $citiesTable)) 
		  	{
		  		$citiesTable[] = $city;
		  		$cities[$country][] = $city;
		  	}
	  	}
 		
 		$countryCityStats = Statistics::getDetailedValuesByCountryAndCity($from, $to, $numberImputations);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_COUNTRY_CITY));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Country/city'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($countries as $country){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate($country));
	 			$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $countryCityStats[$country][0]);
	 			$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $countryCityStats[$country][1].' %');
	 			$active_sheet->setCellValueByColumnAndRow(3, $this->_row,  gmdate('G', $countryCityStats[$country][2]).'h'.gmdate('i', $countryCityStats[$country][2]));
	 			 
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	 					
	 			$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'DDDDDD'),
	 				'endcolor'   => array('rgb' => 'DDDDDD') 
	 			));
	 			
		 		$this->nextLine();
		 		
		 		foreach($cities[$country] as $city){
		 			
		 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $city);
			 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $countryCityStats[$country][$city][0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $countryCityStats[$country][$city][1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $countryCityStats[$country][$city][2]).'h'.gmdate('i', $countryCityStats[$country][$city][2]));
		 			
			 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()->setIndent(1);
			 		
			 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
		 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 		
		 			$this->nextLine();
		 		}
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByDay($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY DAY/TIME -----------------*/
 		
 		$days = Array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
 		
		$timeslots = Array('8h-12h', '12h-16h', '16h-20h', '20h-24h');
		
		$hours[$timeslots[0]] = Array('8h-9h','9h-10h','10h-11h','11h-12h');
	  	$hours[$timeslots[1]] = Array('12h-13h','13h-14h','14h-15h','15h-16h');
	  	$hours[$timeslots[2]] = Array('16h-17h','17h-18h','18h-19h','19h-20h');
	  	$hours[$timeslots[3]] = Array('20h-21h','21h-22h','22h-23h','23h-24h');
		
		$dayStats = Statistics::getDetailedValuesByDay($from, $to, $numberImputations);

		// KYXAR 0010 : Changement du nom de la fonction getDetailedValuesByTimeSlot -> getDetailedValuesByDaysAndTimeSlot
		//$dayAndTimeSlotStats = Statistics::getDetailedValuesByTimeSlot($from, $to);
		$dayAndTimeSlotStats = Statistics::getDetailedValuesByDaysAndTimeSlot($from, $to);

	  	$hourStats = Statistics::getDetailedValuesByHour($from, $to, $dayStats);
	  	
	  		/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_DAY_TIME));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Day/time slot'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($days as $day){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate($day));
	 			
	 			$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'DDDDDD'),
	 				'endcolor'   => array('rgb' => 'DDDDDD') 
	 			));
	 			
	 			if(isset($dayStats[$day])){
	 				
			 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $dayStats[$day][0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $dayStats[$day][1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $dayStats[$day][2]).'h'.gmdate('i', $dayStats[$day][2]));
			 		
	 			}else{
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
			 		
	 			}
		 		
		 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();
	 			
	 			foreach ($timeslots as $timeslot){
	 				
	 				foreach ($hours[$timeslot] as $hour){
	 					
	 					$active_sheet->setCellValueByColumnAndRow(0, $this->_row, '  '.$hour);
	 					
	 					if(isset($hourStats[$day])){
	 						
	 						if(isset($hourStats[$day][$hour])){
	 							
	 							$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $hourStats[$day][$hour][0]);
						 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $hourStats[$day][$hour][1].' %');
						 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $hourStats[$day][$hour][2]).'h'.gmdate('i', $hourStats[$day][$hour][2]));
						 		
	 						}else{
	 							
	 							$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
						 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
						 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 							
	 						}
	 						
	 					}else{
	 						$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
					 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
					 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 					}
	 					
	 					$active_sheet->getStyle('A'.$this->_row)->getAlignment()->setIndent(1);
			 		
				 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 					
	 					$this->nextLine();
	 					
	 				}
	 			}
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByPublicCategory($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY PUBLIC CATEGORY -----------------*/
 		
 		$publicCategoryStats = Statistics::getDetailedValuesByPublicCategory($from, $to, $numberImputations);

 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_PUBLIC_CATEGORY));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Public category'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($publicCategoryStats['cat'] as $category => $publicCategoryStat){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate($category));
	 			
	 			if(isset($publicCategoryStat)){
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $publicCategoryStat[0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $publicCategoryStat[1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $publicCategoryStat[2]).'h'.gmdate('i', $publicCategoryStat[2]));
	 				
	 			}else{
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 				
	 			}
		 		
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();	
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByAct($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY ACT -----------------*/
 		
 		$actStats = Statistics::getDetailedValuesByAct($from, $to, $numberImputations);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_ACT));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Act'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($actStats['act'] as $actDesignation => $actStat){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $actDesignation);
	 			
	 			if(isset($actStat)){
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $actStat[0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $actStat[1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $actStat[2]).'h'.gmdate('i', $actStat[2]));
	 				
	 			}else{
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 				
	 			}
		 		
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();	
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesBySeg($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY SEG -----------------*/
 		
 		$segStats = Statistics::getDetailedValuesBySeg($from, $to, $numberImputations);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_SEG));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('SEG'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($segStats['seg'] as $segDesignation => $segStat){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate($segDesignation));
	 			
	 			if(isset($segStat)){
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $segStat[0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $segStat[1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $segStat[2]).'h'.gmdate('i', $segStat[2]));
	 				
	 			}else{
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 				
	 			}
		 		
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();	
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 		
 		
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByBuilding($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY BUILDING -----------------*/
 		
 		$buildingStats = Statistics::getDetailedValuesByBuilding($from, $to, $numberImputations);
	  	$roomStats = Statistics::getDetailedValuesByRoom($from, $to);
	  	$computerStats = Statistics::getDetailedValuesByComputer($from, $to);
	  	
	  		/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_BUILDING));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Building/room/computer'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($buildingStats['building'] as $building => $buildingStat){

	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $building);
	 			
	 			if(isset($buildingStat)){
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $buildingStat[0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $buildingStat[1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $buildingStat[2]).'h'.gmdate('i', $buildingStat[2]));
	 			}else{
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 			}
	 			
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 			$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'DDDDDD'),
	 				'endcolor'   => array('rgb' => 'DDDDDD') 
	 			));
	 			
	 			$this->nextLine();	
	 			
	 			if(isset($roomStats['room'][$building]))
	 			{
		 			foreach($roomStats['room'][$building] as $room => $roomStat){
		 				
			 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, '  '.$room);
			 			
			 			if(isset($roomStat)){
			 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $roomStat[0]);
					 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $roomStat[1].' %');
					 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $roomStat[2]).'h'.gmdate('i', $roomStat[2]));
			 			}else{
			 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
					 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
					 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
			 			}
		 				
			 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 			
		 				$this->nextLine();	
		 				
		 				if(isset($computerStats['computer'][$building][$room]))
		 				{
			 				foreach($computerStats['computer'][$building][$room] as $computer => $computerStat){
			 					
				 				$active_sheet->setCellValueByColumnAndRow(0, $this->_row, '    '.$this->_translate($computer));
					 			
					 			if(isset($computerStat)){
					 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $computerStat[0]);
							 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $computerStat[1].' %');
							 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $computerStat[2]).'h'.gmdate('i', $computerStat[2]));
					 			}else{
					 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
							 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
							 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
					 			}
					 			
					 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				 			
			 					$this->nextLine();	
			 					
			 				}
		 				}
		 			}
	 			}
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 		
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByTypeOfConnection($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY TYPE OF CONNEXION -----------------*/
 		
 		$typeOfConnectionStats = Statistics::getDetailedValuesByTypeOfConnection($from, $to);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_CONNECTION));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Type of connection'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($typeOfConnectionStats['type'] as $typeOfConnection => $typeOfConnectionStat){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $typeOfConnection);
	 			
	 			if(isset($typeOfConnectionStat)){
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $typeOfConnectionStat[0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $typeOfConnectionStat[1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $typeOfConnectionStat[2]).'h'.gmdate('i', $typeOfConnectionStat[2]));
	 				
	 			}else{
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 				
	 			}
		 		
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();	
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $typeOfConnectionStats['totalUses']);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $typeOfConnectionStats['totalTime']).'h'.gmdate('i', $typeOfConnectionStats['totalTime']));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 * @param unknown_type $numberImputations
 	 * @param unknown_type $totalDuration
 	 */
 	private function _exportDetailedValuesByAwareness($from, $to, $numberImputations, $totalTime){
 		
 		$begin_row = $this->_row;
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/* --------------- EXPORTATION OF THE DETAILED STATS BY AWARENESS -----------------*/
 		
 		$awarenessStats = Statistics::getDetailedValuesByAwareness($from, $to, $numberImputations);
 		
 			/*------------------------------ TITLE -----------------------------*/
 			
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate(self::BY_AWARENESS));
		  	
		  	$active_sheet->mergeCells('A'.$this->_row.':D'.$this->_row);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('A'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => '808080'),
	 				'endcolor'   => array('rgb' => '808080') 
	 		));
 		
 			/*----------------------------- END TITLE ---------------------------*/
	 		
	 	$this->nextLine();
	 	
	 		/*------------------------------ HEADER -----------------------------*/
 		
 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Way of awareness'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $this->_translate('Total of uses (with a duration or not)'));
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $this->_translate('Percentage'));
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, $this->_translate('Time'));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 	
 			/*----------------------------- END HEADER ---------------------------*/
	 				
	 	$this->nextLine();	
	 	
	 		/*------------------------------ BODY -----------------------------*/		
	 		
	 		foreach($awarenessStats['awareness'] as $wayOfAwareness => $awarenessStat){
	 			
	 			$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate($wayOfAwareness));
	 			
	 			if(isset($awarenessStat)){
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $awarenessStat[0]);
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, $awarenessStat[1].' %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $awarenessStat[2]).'h'.gmdate('i', $awarenessStat[2]));
	 				
	 			}else{
	 				
	 				$active_sheet->setCellValueByColumnAndRow(1, $this->_row, '0');
			 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '0 %');
			 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, '0h00');
	 				
	 			}
		 		
	 			$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
			 		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();	
	 		}
	 			
	 		
	 		/*----------------------------- END BODY ---------------------------*/
	 	
	 		/*------------------------------ FOOTER -----------------------------*/
	 	
	 		$active_sheet->setCellValueByColumnAndRow(0, $this->_row, $this->_translate('Total'));
	 		$active_sheet->setCellValueByColumnAndRow(1, $this->_row, $numberImputations);
	 		$active_sheet->setCellValueByColumnAndRow(2, $this->_row, '100%');
	 		$active_sheet->setCellValueByColumnAndRow(3, $this->_row, gmdate('G', $totalTime).'h'.gmdate('i', $totalTime));
	 		
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getStyle('B'.$this->_row.':D'.$this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyle('A'.$this->_row.':D'.$this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		/*----------------------------- END FOOTER ---------------------------*/
	 	
	 	$active_sheet->getStyle('A'.($begin_row+1).':D'.$this->_row)->applyFromArray( array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => PHPExcel_Style_Color::COLOR_BLACK),
				),
			),
		));
 	}
 	
 	
 	/**
 	 * 
 	 * @param $statement
 	 */
 	private function _exportQuantitativeStatementHeader($statement){
 		
 		
 		
 		/* --------- PRINT ALL THE ACTS AT THE TOP OF THE PAGE: -----------*/
 		$num_column = 0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		$active_sheet->getDefaultStyle()->getFont()->setSize(6);
 		
		$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('Criterias'));
	  	
	  	$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 				
 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 		
 		$active_sheet->getColumnDimensionByColumn($num_column, $this->_row)->setAutoSize(true);
 		
 		$num_column++;
	  	
		foreach($statement as $act => $stat){
			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($act);
			
			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
	 		
	 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				
	 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
	 		
	 		$active_sheet->getColumnDimensionByColumn($num_column, $this->_row)->setAutoSize(true);
			
			$num_column++;
		}
		
		$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('Total'));

		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 		));
 		
 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
 				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 				
 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 		
 		$active_sheet->getColumnDimensionByColumn($num_column, $this->_row)->setAutoSize(true);
		
	 	$this->nextLine(2);
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $statement
 	 * @param unknown_type $stat_type
 	 * @param unknown_type $total
 	 */
 	private function _exportQuantitativeStatementRessourceByString($columns, $statement, $stat_type, $total){
 		
 		$num_column=0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		$valid_types = array('Global Data', 'Gender', 'Age range');
 		
 		if(in_array($stat_type, $valid_types)){
 			
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate(($stat_type != 'Global Data') ? ('By '.(($stat_type != 'SEG') ? strtolower($stat_type) : $stat_type)) : $stat_type));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
 			
 			$this->nextLine();
 			
	 		foreach($columns[$stat_type] as $column){
	 			
	 			if(!is_array($column)){
	 				
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($column));
	
		 			$num_column++;
		 			
		 			foreach($statement as $stat){
		 				//echo($stat_type.'=>'.$column.'<br>');
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($stat[$column]) ? $stat[$column] : '0');
		 				
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 						
		 				$num_column++;
		 			}
		 			
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($total[$column]) ? $total[$column]: '0');
		 			
		 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 					
		 			$this->nextLine();
		 			$num_column=0;
		 			
	 			}
	 		}
	 		$this->nextLine(2);
 		}
 		
 	}
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $statement
 	 * @param unknown_type $stat_type
 	 * @param unknown_type $total
 	 */
 	private function _exportQuantitativeStatementRessourceById($columns, $statement, $stat_type, $total){
 		
 		$num_column=0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		$stat_type_2 = ($stat_type == 'Type of connection') ? 'Connection' : $stat_type;
 		
 		$valid_types = array('Category', 'SEG', 'Type of connection', 'Awareness');
 		
 		if(in_array($stat_type, $valid_types)){
 			
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('By '.(($stat_type != 'SEG') ? strtolower($stat_type) : $stat_type)));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
 			
 			$this->nextLine();
 			
	 		foreach($columns[$stat_type] as $id => $column){
	 			
	 			if(!is_array($column)){
	 				
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($column));
	
		 			$num_column++;
		 			
		 			foreach($statement as $stat){
		 				//echo($stat_type.'=>'.$column.'<br>');
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue((isset($stat[$stat_type_2]) && isset($stat[$stat_type_2][$id])) ? $stat[$stat_type_2][$id] : '0');
		 				
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 						
		 				$num_column++;
		 			}
		 			
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($total[$stat_type_2][$id]) ? $total[$stat_type_2][$id]: '0');
		 			
		 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 					
		 			$this->nextLine();
		 			$num_column=0;
		 			
	 			}
	 		}
	 		$this->nextLine(2);
 		}
 		
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $statement
 	 * @param unknown_type $total
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 */
 	private function _exportQuantitativeStatementByCountry($columns, $statement, $total, $from, $to){
 		
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		$num_column=0;
 		
 		$countries = array();
	  	$citiesTable = array();
	  	$cities = array();
 		
	 	$imputations = Doctrine_Query::create()
		    ->select('i.*')
		    ->from('ImputationArchive i')
	  		->where('imputation_date BETWEEN ? AND ?',array($from,$to))
	  		->execute();	
	  		
	  	foreach($imputations as $imputation)
	  	{
	  		$country = $imputation->getUserArchive()->getCountry();
	  		$city = $imputation->getUserArchive()->getCityName();
		  	if(!in_array($country, $countries)) $countries[] = $country;
		  	if(!in_array($city, $citiesTable)) 
		  	{
		  		$citiesTable[] = $city;
		  		$cities[$country][] = $city;
		  	}
	  	}
	  	
		  	/* ------------------------------------------- TITLE ---------------------------------------*/
		  	
	  		$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate(self::BY_COUNTRY_CITY));
	 			
	 		$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 		
	 		/* ---------------------------------------- END TITLE ---------------------------------------*/
	 			
	 	$this->nextLine();
	 	$num_column=0;
	 	
	 		/* ------------------------------------------- BODY ---------------------------------------*/	
	 		
	 		foreach($countries as $country){
	 			
	 			//We print the name of the country:
	 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($country);
	 			$num_column++;
	 			
	 			//And its statistics:
	 			foreach($statement as $stat){
	 				
	 				if(isset($stat[$country])){
	 					$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($stat[$country][0]);
	 				}else{
	 					$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
	 				}
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			//Print the total of this country:
	 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($total[$country][0]);
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			
	 			$this->nextLine();
	 			$num_column=0;
	 			
	 			//Then for each city in this country:
	 			foreach($cities[$country] as $city){
	 				
	 				//We print the name of the city:
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('  '.$city);
		 			$num_column++;
		 			
		 			//And its statistics:
		 			foreach($statement as $stat){
		 				
		 				if(isset($stat[$country])&&(isset($stat[$country][$city]))){
		 					$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue( $stat[$country][$city]);
		 				}else{
	 						$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
	 					}
	 					
	 					$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 					$num_column++;
		 			}
		 			//We print the total of this city:
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($total[$country][$city]);
		 			
		 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 			
		 			$this->nextLine();
		 			$num_column=0;
	 				
	 			}
	 		}
	 		/* ---------------------------------------- END BODY ---------------------------------------*/
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $statement
 	 * @param unknown_type $total
 	 */
 	private function _exportQuantitativeStatementByDay($columns, $statement, $total){
 		
 		$num_column=0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		
 			/* ------------------------------------------- TITLE ---------------------------------------*/
 		
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate(self::BY_DAY_TIME));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 		/* ---------------------------------------- END TITLE ---------------------------------------*/
 			
 		$this->nextLine();
 		$num_column=0;
 		
 			/* ------------------------------------------- BODY ---------------------------------------*/
 			
	 		foreach($columns['Day'] as $day){
	 			
	 			//For each day, we print its global data:
	 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($day));
	 			$num_column++;
	 			
	 			foreach($statement as $stat){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($stat[$day]) ? $stat[$day][0] : '0');
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 						
	 				$num_column++;
	 			}
	 			
	 			//The total of the day:
	 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($total[$day]) ? $total[$day][0]: '0');
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 					
	 			$this->nextLine();
	 			$num_column=0;
	 			
	 			//Then for each day we print the data for each hour of this day:
	 			foreach($columns['Time slot'] as $timeSlot){
	 				
	 				foreach($columns[$timeSlot]['Hour'] as $hour){
	 					
	 					$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('  '.$hour);
	 					
	 					$num_column++;
	 					
	 					foreach($statement as $stat){
	 						
	 						if(isset($stat[$day]) && isset($stat[$day][$hour])){
	 							
	 							$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($stat[$day][$hour]);
	 						 							
	 						}else{
	 							$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
	 						}
	 						
	 						$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 					
			 				$num_column++;
	 					}
	 					
	 					//The total of the hour:
			 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue((isset($total[$day]) && isset($total[$day][$hour])) ? $total[$day][$hour]: '0');
			 			
			 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 					
			 			$this->nextLine();
			 			$num_column=0;
	 				}
	 			}
		 			
	 		}
	 		
	 		/* ---------------------------------------- END BODY ---------------------------------------*/
 		
 	}
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $statement
 	 * @param unknown_type $total
 	 */
 	private function _exportQuantitativeStatementByBuilding($columns, $statement, $total){
 		
 		$num_column=0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		
 			/* ------------------------------------------- TITLE ---------------------------------------*/
 		
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate(self::BY_BUILDING));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 		/* ---------------------------------------- END TITLE ---------------------------------------*/
 			
 		$this->nextLine();
 		$num_column=0;
 		
 			/* ------------------------------------------- BODY ---------------------------------------*/
 			
	 		foreach($columns['Building'] as $buildingId => $building){
	 			
	 			//For each building, we print its global data:
	 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($building);
	 			$num_column++;
	 			
	 			foreach($statement as $stat){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue((isset($stat['Building']) && isset($stat['Building'][$buildingId])) ? $stat['Building'][$buildingId][0] : '0');
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
 						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 						
	 				$num_column++;
	 			}
	 			
	 			//The total of the building:
	 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($total['Building'][$buildingId]) ? $total['Building'][$buildingId][0]: '0');
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 					
	 			$this->nextLine();
	 			$num_column=0;
	 			
	 			//Then for each building we print the data for each room of this building:
	 			foreach($columns[$buildingId]['Room'] as $roomId => $room){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('  '.$room);
	 					
 					$num_column++;
 					
 					foreach($statement as $stat){
 						
 						if(isset($stat['Building']) && isset($stat['Building'][$buildingId]) && isset($stat['Building'][$buildingId][$roomId])){
 							
 							$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($stat['Building'][$buildingId][$roomId][0]);
 						 							
 						}else{
 							$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
 						}
 						
 						$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 					
		 				$num_column++;
 					}
 					
 					//The total of the room:
		 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue((isset($total['Building'][$buildingId]) && (isset($total['Building'][$buildingId][$roomId]))) ? $total['Building'][$buildingId][$roomId][0]: '0');
		 			
		 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
	 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 					
		 			$this->nextLine();
		 			$num_column=0;
	 				
		 			//Then for each room we print the data for each computer of this room:
	 				foreach($columns[$buildingId][$roomId]['Computer'] as $computerId => $computer){
	 					
	 					$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('    '.$this->_translate($computer));
	 					
	 					$num_column++;
	 					
	 					foreach($statement as $stat){
	 						
	 						if(isset($stat['Building']) && isset($stat['Building'][$buildingId]) && isset($stat['Building'][$buildingId][$roomId]) && isset($stat['Building'][$buildingId][$roomId][$computerId])){
	 							
	 							$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($stat['Building'][$buildingId][$roomId][$computerId]);
	 						 							
	 						}else{
	 							$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
	 						}
	 						
	 						$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 					
			 				$num_column++;
	 					}
	 					
	 					//The total of the computer:
			 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue((isset($total['Building'][$buildingId]) && (isset($total['Building'][$buildingId][$roomId])) && (isset($total['Building'][$buildingId][$roomId][$computerId]))) ? $total['Building'][$buildingId][$roomId][$computerId][0]: '0');
			 			
			 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 					
			 			$this->nextLine();
			 			$num_column=0;
	 				}
	 			}
		 			
	 		}
	 		
	 		/* ---------------------------------------- END BODY ---------------------------------------*/
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 */
 	private function _exportDetailsPerCategory($columns, $details, $total){
 		
 		$num_column=0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		
 		/*------------------------------------- HEADER --------------------------------------*/
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('Details per categories'));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
 				'startcolor' => array('rgb' => 'C0C0C0'),
 				'endcolor'   => array('rgb' => 'C0C0C0') 
 			));
 			$num_column++;
 			
 			foreach($columns['Gender'] as $gender){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($gender));
 			
 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			$num_column++;
 			}
 			
 			foreach($columns['City'] as $city){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($city);
 			
 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			$num_column++;
 			}
 			
 			foreach($columns['Age range'] as $ageRange){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($ageRange));
 			
 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			$num_column++;
 			}
 			
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('Total'));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
 				'startcolor' => array('rgb' => 'C0C0C0'),
 				'endcolor'   => array('rgb' => 'C0C0C0') 
 			));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 			
 		/*------------------------------------ END HEADER -----------------------------------*/
 			
 		$this->nextLine();
 		$num_column=0;
 		
 		/*------------------------------------- BODY --------------------------------------*/
 		
 			foreach($columns['Category'] as $id => $category){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($category));
 				$num_column++;
 				
	 			foreach($columns['Gender'] as $gender){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per category'][$id][$gender]) ? $details['Details per category'][$id][$gender] : '0');
		 			
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			
	 			foreach($columns['City'] as $city){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per category'][$id][$city]) ? $details['Details per category'][$id][$city] : '0');
		 			
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			
	 			foreach($columns['Age range'] as $ageRange){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per category'][$id][$ageRange]) ? $details['Details per category'][$id][$ageRange] : '0');
		 			
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			
	 			if(isset($total['Category'][$id])){
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($total['Category'][$id]);
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			}else{
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			}
	 			
	 			$this->nextLine();
 				$num_column=0;
 			}
 		
 		/*------------------------------------ END BODY -----------------------------------*/
 	}
 	
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $columns
 	 * @param unknown_type $from
 	 * @param unknown_type $to
 	 */
 	private function _exportDetailsPerTimeSlot($columns, $details, $total){
 		
 		$num_column=0;
 		$active_sheet = $this->getDocument()->getActiveSheet();
 		
 		/*------------------------------------- HEADER --------------------------------------*/
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('Details per time slots'));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
 				'startcolor' => array('rgb' => 'C0C0C0'),
 				'endcolor'   => array('rgb' => 'C0C0C0') 
 			));
 			$num_column++;
 			
 			foreach($columns['Gender'] as $gender){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($gender));
 			
 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			$num_column++;
 			}
 			
 			foreach($columns['City'] as $city){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($city);
 			
 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			$num_column++;
 			}
 			
 			foreach($columns['Age range'] as $ageRange){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($ageRange));
 			
 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 				
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
	 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	 				'startcolor' => array('rgb' => 'C0C0C0'),
	 				'endcolor'   => array('rgb' => 'C0C0C0') 
	 			));
	 			
	 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			$num_column++;
 			}
 			
 			$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate('Total'));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFont()->setBold(true);
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getFill()->applyFromArray(array(
 				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
 				'startcolor' => array('rgb' => 'C0C0C0'),
 				'endcolor'   => array('rgb' => 'C0C0C0') 
 			));
 			
 			$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 			
 		/*------------------------------------ END HEADER -----------------------------------*/
 			
 		$this->nextLine();
 		$num_column=0;
 		
 		/*------------------------------------- BODY --------------------------------------*/
 			
 			foreach($columns['Day'] as $day){
 				
 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($this->_translate($day));
 				$num_column++;
 				
	 			foreach($columns['Gender'] as $gender){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per time slot'][$day][$gender]) ? $details['Details per time slot'][$day][$gender] : '0');
		 			
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			
	 			foreach($columns['City'] as $city){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per time slot'][$day][$city]) ? $details['Details per time slot'][$day][$city] : '0');
		 			
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			
	 			foreach($columns['Age range'] as $ageRange){
	 				
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per time slot'][$day][$ageRange]) ? $details['Details per time slot'][$day][$ageRange] : '0');
		 			
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 				$num_column++;
	 			}
	 			
	 			if(isset($total[$day])){
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($total[$day][0]);
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			}else{
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
	 				
	 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
		 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	 			}
 				
 				$this->nextLine();
 				$num_column=0;
 				
 				foreach($columns['Hour'] as $hour){
 					
	 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('  '.$this->_translate($hour));
	 				$num_column++;
	 				
		 			foreach($columns['Gender'] as $gender){
		 				
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per time slot'][$day][$hour][$gender]) ? $details['Details per time slot'][$day][$hour][$gender] : '0');
			 			
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
			 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 				$num_column++;
		 			}
		 			
		 			foreach($columns['City'] as $city){
		 				
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per time slot'][$day][$hour][$city]) ? $details['Details per time slot'][$day][$hour][$city] : '0');
			 			
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
			 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 				$num_column++;
		 			}
		 			
		 			foreach($columns['Age range'] as $ageRange){
		 				
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue(isset($details['Details per time slot'][$day][$hour][$ageRange]) ? $details['Details per time slot'][$day][$hour][$ageRange] : '0');
			 			
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
			 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 				$num_column++;
		 			}
		 			
		 			if(isset($total[$day][$hour])){
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue($total[$day][$hour]);
		 				
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
			 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 			}else{
		 				$active_sheet->getCellByColumnAndRow($num_column, $this->_row)->setValue('0');
		 				
		 				$active_sheet->getStyleByColumnAndRow($num_column, $this->_row)->getAlignment()
			 					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 			}
 					
 					$this->nextLine();
 					$num_column=0;
 				}
 			}
 		
 		/*------------------------------------ END BODY -----------------------------------*/
 	}
 	
 	
 	/**
 	 * 
 	 * @param unknown_type $statement
 	 */
 	private static function formatStatement($statement){
 		
 		foreach($statement as $stat_index => $stat){
 			
 			foreach($stat as  $first_index => $first_level){
 				
 				if(!is_array($first_level)){
 					$statement[$stat_index][$first_index] = ($first_level != 0) ? gmdate('G', $first_level).'h'.gmdate('i', $first_level) : '0';
 				}else{
 					foreach($first_level as $second_index => $second_level){
 						
 						if(!is_array($second_level)){
 							$statement[$stat_index][$first_index][$second_index] = ($second_level != 0) ? gmdate('G', $second_level).'h'.gmdate('i', $second_level) : '0';
 						}else{
 							foreach($second_level as $third_index => $third_level){
 								if(!is_array($third_level)){
 									$statement[$stat_index][$first_index][$second_index][$third_index] = ($third_level != 0) ? gmdate('G', $third_level).'h'.gmdate('i', $third_level) : '0';
 								}else{
 									foreach($third_level as $fourth_index => $fourth_level){
 										$statement[$stat_index][$first_index][$second_index][$third_index][$fourth_index] = ($fourth_level != 0) ? gmdate('G', $fourth_level).'h'.gmdate('i', $fourth_level) : '0';
 									}
 								}
 							}
 						}
 					}
 				}
 				
 			}
 		}
 		
 		return $statement;
 	}
 	
 	
 	
   /**
 	 * 
 	 * @param unknown_type $total
 	 */
 	private static function formatTotal($total){
 		
 		
 		foreach($total as $stat_index => $stat){
 			
 			if(!is_array($stat)){
 				$total[$stat_index] = ($stat != 0) ? gmdate('G', $stat).'h'.gmdate('i', $stat) : '0';
 			}else{
 				
 				foreach($stat as  $first_index => $first_level){
 				
	 				if(!is_array($first_level)){
	 					$total[$stat_index][$first_index] = ($first_level != 0) ? gmdate('G', $first_level).'h'.gmdate('i', $first_level) : '0';
	 				}else{
	 					foreach($first_level as $second_index => $second_level){
	 						
	 						if(!is_array($second_level)){
	 							$total[$stat_index][$first_index][$second_index] = ($second_level != 0) ? gmdate('G', $second_level).'h'.gmdate('i', $second_level) : '0';
	 						}else{
	 							foreach($second_level as $third_index => $third_level){
	 								if(!is_array($third_level)){
	 									$total[$stat_index][$first_index][$second_index][$third_index] = ($third_level != 0) ? gmdate('G', $third_level).'h'.gmdate('i', $third_level) : '0';
	 								}else{
		 								foreach($third_level as $fourth_index => $fourth_level){
	 										$total[$stat_index][$first_index][$second_index][$third_index][$fourth_index] = ($fourth_level != 0) ? gmdate('G', $fourth_level).'h'.gmdate('i', $fourth_level) : '0';
	 									}
	 								}
	 							}
	 						}
	 					}
	 				}
 				
 				}
 			}
 			
 			
 		}
 		
 		return $total;
 	}
 }