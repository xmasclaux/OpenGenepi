<?php

/**
 * reservation actions.
 *
 * @package    GENEPI
 * @subpackage reservation
 * @author     Kyxar (www.kyxar.fr)
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reservationActions extends sfActions
{
    // ------------------------------------------------------------------------------------------

    private function execQuery($sql)
    {
        $dq = new Doctrine_Query();
        $conn = $dq->getConnection();
        return $conn->execute($sql);
    }

    // ------------------------------------------------------------------------------------------

    private function insert($table_name, $d)
    {
        $table = Doctrine::getTable($table_name);
        $dq = new Doctrine_Query();
        $conn = $dq->getConnection();
        return $conn->insert($table, $d);
    }

    // ------------------------------------------------------------------------------------------

    private function update($table_name, $d, $id)
    {
        $tid = $id;
        if (!is_array($id))
            $tid = array('id' => $id);

        $table = Doctrine::getTable($table_name);
        $dq = new Doctrine_Query();
        $conn = $dq->getConnection();
        return $conn->update($table, $d, $tid);
    }

    // ------------------------------------------------------------------------------------------

    private function unHtmlSpecial($string)
    {
        $string = str_replace ( '&amp;', '&', $string );
        $string = str_replace ( '&#039;', "'", $string );
        $string = str_replace ( '&quot;', '\"', $string );
        $string = str_replace ( '&lt;', '<', $string );
        $string = str_replace ( '&gt;', '>', $string );
        return $string;
    }

    // ------------------------------------------------------------------------------------------

    private function getMenu($actif = 'index')
    {
        $actions = array(
            array('key'=> 'index',     'label' => 'Calendar'),
            //array('key'=> 'list',      'label' => 'Reservations'),
            //array('key'=> 'events',    'label' => 'Events')
        );

        foreach ($actions as $k => $action)
        {
            if ($action['key'] == $actif)
            {
                $actions[$k]['active'] = 1;
                break;
            }
        }

        return $actions;
    }

    // ------------------------------------------------------------------------------------------

    public function executeIndex(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('index');

        $this->computer_reservations = Doctrine::getTable('ReservationComputer')
            ->createQuery('rc')
            ->leftJoin('rc.Computer c')
            ->leftJoin('rc.Reservation rs')
            ->orderBy('rc.start_date')
            ->execute();

        $this->room_reservations = Doctrine::getTable('ReservationRoom')
            ->createQuery('rr')
            ->leftJoin('rr.Room r')
            ->leftJoin('rr.Reservation rs')
            ->orderBy('rr.start_date')
            ->execute();

        $this->computers = Doctrine::getTable('Computer')
            ->createQuery('c')
            ->orderBy('c.name')
            ->execute();

        $this->rooms = Doctrine::getTable('Room')
            ->createQuery('r')
            ->orderBy('r.designation')
            ->execute();
    }

    // ------------------------------------------------------------------------------------------

    public function executeAjaxLoadEvents(sfWebRequest $request, $xhr = true)
    {
        $this->xhr = $xhr;

        
        // init des paramètres
        $start = $request->getParameter('start');
        $end = $request->getParameter('end');
        $room_filter = $request->getParameter('room_filter');
        $computer_filter = $request->getParameter('computer_filter');

        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', $end + 60 * 60 * 24);

        $reservations = array();

        
        // recherche des réservations d'ordinateur
        $o = Doctrine::getTable('ReservationComputer')
            ->createQuery('rc')
            ->leftJoin('rc.Computer c')
            ->leftJoin('rc.Reservation rs')
            ->addWhere('rc.start_date >= ?', $start_date)
            ->addWhere('rc.end_date < ?', $end_date);

        
        // traitement du filtre de salle
        if ($room_filter)
        {
        	
        	// si on demande que des salles, alors on ne prend aucun ordinateur
            if ( $room_filter == 'room' )
                $o->addWhere('rc.id = ?', 0);
            
            // si une salle précise est demandée, on ne prend que les ordinateurs de la salle
            else
            {
            	$t = explode('-', $room_filter);
            	if ($t[1])
            		$o->addWhere('c.room_id = ?', $t[1]);
            }
        }

        
        // traitement du filtre d'ordinateur
        if ( $computer_filter )
        {
        	// on ne prend que l'ordinateur sélectionné si le filtre est renseigné
        	$t = explode('-', $computer_filter);
        	if ($t[1])
        		$o->addWhere('c.id = ?', $t[1]);
        }
        
        
        $computer_reservations = $o
            ->orderBy('rc.start_date')
            ->execute();

        foreach ($computer_reservations as $computer_reservation)
        {
            $reservations[] = array(
                'id' => $computer_reservation->getReservationId(),
                'title' => $this->unHtmlSpecial($computer_reservation->getReservation()->getDesignation()).' - Â«'.$this->unHtmlSpecial($computer_reservation->getComputer()->getName()).'Â»',
                'start' => $computer_reservation->getStartDate(),
                'end' => $computer_reservation->getEndDate(),
                'allDay' => false,
                'textColor' => '#FFFFFF',
                'backgroundColor' => '#800000'
            );
        }

        
        // Recherche des réservations de salle
        $o = Doctrine::getTable('ReservationRoom')
            ->createQuery('rr')
            ->leftJoin('rr.Room r')
            ->leftJoin('rr.Reservation rs')
            ->addWhere('rr.start_date >= ?', $start_date)
            ->addWhere('rr.end_date < ?', $end_date);

        
        // traitement du filtre de salle
        if ($room_filter)
        {

        	// on ne prend que la salle sélectionnée si le filtre est renseigné
            $t = explode('-', $room_filter);
            if ($t[1])
                $o->addWhere('r.id = ?', $t[1]);
        }
        
        // traitement du filtre d'ordinateur
        if ($computer_filter)
        {
        	// si un filtre ordinateur est sélectionné, on ne prend aucune salle
        	$o->addWhere('r.id = ?',0);
        }

        $room_reservations = $o
            ->orderBy('rr.start_date')
            ->execute();

        foreach ($room_reservations as $room_reservation)
        {
            $reservations[] = array(
                'id' => $room_reservation->getReservationId(),
                'title' => $this->unHtmlSpecial($room_reservation->getReservation()->getDesignation()).' - Â«'.$this->unHtmlSpecial($room_reservation->getRoom()->getDesignation()).'Â»',
                'start' => $room_reservation->getStartDate(),
                'end' => $room_reservation->getEndDate(),
                'allDay' => false,
                'textColor' => '#FFFFFF',
                'backgroundColor' => '#333333'
            );
        }

        
        // envoi de la réponse
        echo json_encode($reservations);
        die();
    }

    // ------------------------------------------------------------------------------------------
    
    /**
     * Appel Ajax pour rendre le choix des ordinateur dynamiques en fonction
     * de la salle dans le filtre du calendrier
     * 
     * @param sfWebRequest $request
     * @return html
     */
    public function executeAjaxSelectComputerByRoom(sfWebRequest $request)
    {
    	
    	// recupère la salle sélectionnée
    	$room_filter = $request->getParameter('room_filter');
    	if ( $room_filter != "" )
    	{
    		$t = explode('-', $room_filter);
            $room_id = $t[1];
            if ( ! $room_id ) $room_id = 0;
    	}
    	
    	// recherche des ordinateurs
    	$o = Doctrine::getTable('Computer')
    	  ->createQuery('c');
    	
    	// si salle filtrée, alors on filtre
    	if ( isset($room_id) )
    		$o->addWhere('c.room_id = ?',$room_id);
    	
    	// et on lance
    	$this->computers = $o
    	  ->orderBy('c.name')
    	  ->execute();
    	
    	// envoi au template
    	$this->setTemplate('selectComputerByRoom','reservation');
    	
    }
    
    // ------------------------------------------------------------------------------------------

    public function executeAjaxDetailedReservation(sfWebRequest $request, $xhr = true)
    {
        $this->xhr = $xhr;

        $reservation_id = $request->getParameter('id');
        
        if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
        {
            echo "";
            die();
        }

        // réservation des ordinateurs
        $this->computer_reservations = Doctrine::getTable('ReservationComputer')
            ->createQuery('rc')
            ->leftJoin('rc.Computer c')
            ->addWhere('rc.reservation_id = ?', $reservation_id)
            ->orderBy('rc.start_date')
            ->execute();

        // réservation des salles
        $this->room_reservations = Doctrine::getTable('ReservationRoom')
            ->createQuery('rr')
            ->leftJoin('rr.Room r')
            ->addWhere('rr.reservation_id = ?', $reservation_id)
            ->orderBy('rr.start_date')
            ->execute();

        
        // event
        $this->event = Doctrine::getTable('Event')
        	->createQuery('re')
        	->addWhere('re.reservation_id = ?', $reservation_id)
        	->execute();

        
        // membres des réservations
        if ( $this->reservation->getType() == 'group' )
        	$sql = "select user.* from user left join group_user on user.id = user_id where group_id = ".$this->reservation->getTypeId();
        else
        	$sql = "select user.* from user where id = ".$this->reservation->getTypeId();
        $this->users = $this->execQuery($sql);
   
        $this->setTemplate('detailedReservation','reservation');
    }

    // ------------------------------------------------------------------------------------------
    
    
    public function executeAjaxEditReservation(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');

    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	$this->users = Doctrine::getTable('User')
    	->createQuery('u')
    	->orderBy('u.surname')
    	->execute();
    	
    	$this->groups = Doctrine::getTable('Groups')
    	->createQuery('g')
    	->orderBy('g.name')
    	->execute();
    	
    	
    	$this->setTemplate('editReservation','reservation');
    }
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxEditEvent(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');
    	
    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	// réservation des salles
    	$this->event = Doctrine::getTable('Event')
    	->createQuery('e')
    	->addWhere('e.reservation_id = ?', $reservation_id)
    	->execute();

    	$this->setTemplate('AjaxEditEvent','reservation');
    	
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxSaveEvent(sfWebRequest $request, $xhr = true)
    {
    	
    	$reservation_id = $request->getParameter('id');
    	$event_id = $request->getParameter('event_id');
    	$event_designation = $request->getParameter('event_designation');
    	$event_description = $request->getParameter('event_description');
    	
    	// ajout d'un event
    	if ( $event_id == "" )
    	{
    		$event = new Event();
    		$event->setDesignation($event_designation);
    		$event->setDescription($event_description);
    		$event->setReservationId($reservation_id);
    		$event->save();
    	}
    	
    	// modification d'un event
    	else
    	{
    		$event = Doctrine::getTable('Event')->find(array($event_id));
    		$event->setDesignation($event_designation);
    		$event->setDescription($event_description);
    		$event->save();
    		
    	}
    	
    	$this->executeAjaxDetailedReservation($request,$xhr);
    	
    }

    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxDeleteEvent(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');
    	$event_id = $request->getParameter('event_id');
    	
    	$event = Doctrine::getTable('Event')->find(array($event_id));
    	$event->Delete();
    	
    	$this->executeAjaxDetailedReservation($request,$xhr);
    	
    		
    }
    
    // ------------------------------------------------------------------------------------------

    public function executeAjaxEditUser(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');
    	
    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	// membres des réservations
    	if ( $this->reservation->getType() == 'group' )
    		$sql = "select user.* from user left join group_user on user.id = user_id where group_id = ".$this->reservation->getTypeId();
    	else
    		$sql = "select user.* from user where id = ".$this->reservation->getTypeId();
    	$this->users = $this->execQuery($sql);
    	
    	
    	$this->setTemplate('editUser','reservation');
    	
    }
    
    // ------------------------------------------------------------------------------------------

    public function executeAjaxSearchUser(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');
    	 
    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	$key = $request->getParameter("search");
    	
    	$sql = "select * from user where name like '%$key%' or surname like '%$key%'";
    	$this->users = $this->execQuery($sql);
    	
    	$this->setTemplate('searchUser','reservation');
    	
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxAddUser(sfWebRequest $request, $xhr = true)
    {
    	
    	$reservation_id = $request->getParameter('id');
    	$user_id = $request->getParameter('user_id');
    	
        if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	
    	// check if user is already in
    	$sql  = "select * from group_user where group_id = '".$this->reservation->getTypeId()."' and user_id = '".$user_id."'";
    	$r = $this->execQuery($sql);
		
    	if ( $r->rowCount() == 0 )
    	{
    		
    		// ajout
    		$sql = "insert into group_user (group_id,user_id) values ('".$this->reservation->getTypeId()."','".$user_id."')";
    		$this->execQuery($sql);
    		
    	}
    	
    	
    	
    	$this->executeAjaxEditUser($request);
    	
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxSupprUser(sfWebRequest $request, $xhr = true)
    {
    	 
    	$reservation_id = $request->getParameter('id');
    	$user_id = $request->getParameter('user_id');
    	 
    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	$group_id = $this->reservation->getTypeId();
    	
    	// suppression
    	$sql = "delete from group_user where group_id = '$group_id' and user_id = '$user_id'";
    	$this->execQuery($sql);
		
    	 
    	 
    	 
    	$this->executeAjaxEditUser($request);
    	 
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxEditPeriod(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');
    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	$this->computer_reservations = Doctrine::getTable('ReservationComputer')
    	->createQuery('rc')
    	->leftJoin('rc.Computer c')
    	->addWhere('rc.reservation_id = ?', $reservation_id)
    	->orderBy('rc.start_date')
    	->execute();
    	
    	$this->room_reservations = Doctrine::getTable('ReservationRoom')
    	->createQuery('rr')
    	->leftJoin('rr.Room r')
    	->addWhere('rr.reservation_id = ?', $reservation_id)
    	->orderBy('rr.start_date')
    	->execute();    	
    	
    	$this->setTemplate('editPeriod','reservation');
    }

    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxSupprResa(sfWebRequest $request, $xhr = true)
    {
    	
    	$id_resa_computer = $request->getParameter('id_resa_computer');
    	$id_resa_room = $request->getParameter('id_resa_room');
    	$id_reservation = $request->getParameter('id');
    	
    	// check if the last one
    	$nb_total = 0;
    	$sql = "select * from reservation_computer where reservation_id = '$id_reservation'";
    	$r = $this->execQuery($sql);
    	$nb_total = $r->rowCount();
    	$sql = "select * from reservation_room where reservation_id = '$id_reservation'";
    	$r = $this->execQuery($sql);
    	$nb_total += $r->rowCount();
    	
    	if ( $nb_total > 1 )
    	{
    	
	    	// suppr resa computer
	    	if ( $id_resa_computer != "" )
	    	{
	    		$sql = "delete from reservation_computer where id = '$id_resa_computer'";
	    		$this->execQuery($sql);
	    	}
	    	
	    	// suppr resa room
	    	if ( $id_resa_room != "" )
	    	{
	    		$sql = "delete from reservation_room where id = '$id_resa_room'";
	    		$this->execQuery($sql);
	    	}
    	
    	}
    	else
    	{
    		$this->error = "Error : you must keep at least one period.";
    	}
    	
    	$this->executeAjaxEditPeriod($request);
    	
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxAddPeriod(sfWebRequest $request, $xhr = true)
    {
    	$reservation_id = $request->getParameter('id');
    	if (!($this->reservation = Doctrine::getTable('Reservation')->find(array($reservation_id))))
    	{
    		echo "";
    		die();
    	}
    	
    	// create new reservation special
    	$startdate = $request->getParameter('startdate');
    	$stopdate = $request->getParameter('stopdate');
    	if ( $startdate != "" )
    	{
    		
    		preg_match("/(?P<year>.*)-(?P<month>.*)-(?P<day>.*) (?P<hour>.*):(?P<minute>.*):(?P<osef>.*)/",$startdate,$start_d);
    		preg_match("/(?P<year>.*)-(?P<month>.*)-(?P<day>.*) (?P<hour>.*):(?P<minute>.*):(?P<osef>.*)/",$stopdate,$stop_d);
    		
    		$this->start_date = "$start_d[day]/$start_d[month]/$start_d[year]";
    		$this->formatted_start = "$start_d[year]-$start_d[month]-$start_d[day]";
    		$this->end_date = "$stop_d[day]/$stop_d[month]/$stop_d[year]";
    		$this->formatted_end = "$stop_d[year]-$stop_d[month]-$stop_d[day]";
    		$this->start_hour = $start_d['hour'];
    		$this->start_minute = $start_d['minute'];
    		$this->end_hour = $stop_d['hour'];
    		$this->end_minute = $stop_d['minute'];
    		$this->create = "1";
    		
    	}
    	
    	$this->computers = Doctrine::getTable('Computer')
    	->createQuery('c')
    	->orderBy('c.name')
    	->execute();
    	
    	$this->rooms = Doctrine::getTable('Room')
    	->createQuery('r')
    	->orderBy('r.designation')
    	->execute();
    	
    	$this->setTemplate('ajaxAddPeriod','reservation');
    	
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeAjaxCreateReservation(sfWebRequest $request, $xh = true)
    {
    	
    	$month = sprintf('%02s', $request->getParameter('m'));
    	$day = sprintf('%02s', $request->getParameter('d'));
    	$year = $request->getParameter('y');
    	$hour = sprintf('%02s', $request->getParameter('h'));
    	$hour_fin = sprintf('%02s', $request->getParameter('h')+1);
    	$min = sprintf('%02s', $request->getParameter('min'));
    	
    	if ( $hour == "" || $hour == "00" ) $hour = "08";
    	if ( $hour_fin == "" || $hour_fin == "01" ) $hour_fin = "09";
    	if ( $min == "" ) $min = "00";
    	
    	$this->startdate = "$year-$month-$day $hour:$min:00";
    	$this->stopdate = "$year-$month-$day $hour_fin:$min:00";
    	
    	$this->setTemplate('editReservation','reservation');
    	
    }
    
    // ------------------------------------------------------------------------------------------
    
    public function executeList(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('list');

        $sql = <<<SQL
                    select *, rc.start_date as date_rc, rr.start_date as date_rr, r.id as id, rc.reservation_id as rcr_id, rr.reservation_id as rrr_id
                    from reservation r
                    left join reservation_computer rc on (rc.reservation_id = r.id)
                    left join reservation_room rr on (rr.room_id = r.id)
SQL;
        $reservations_tmp = $this->execQuery($sql);
        $reservations = array();
        $ids = array();
        foreach ($reservations_tmp as $k => $reservation)
        {
            if ($ids[$reservation['id']])
                continue;
            $ids[$reservation['id']] = 1;

            $idx = $reservation['date_rc'].'-'.$reservation['rcr_id'];
            if (!$idx)
                $idx = $reservation['date_rr'].'-'.$reservation['rrr_id'];
            if (!$idx)
                $idx = 'z'.$reservation['id'];
            $reservations[$idx] = $reservation;
        }

        ksort($reservations);

        $this->reservations = $reservations;
    }

    // ------------------------------------------------------------------------------------------

    public function executeForm(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('list');

        $reservation_id = $request->getParameter('id');
        if ($reservation_id)
        {
            $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));
            $this->reservation = $reservation;
        }

        $this->users = Doctrine::getTable('User')
            ->createQuery('u')
            ->orderBy('u.surname')
            ->execute();

        $this->groups = Doctrine::getTable('Groups')
            ->createQuery('g')
            ->orderBy('g.name')
            ->execute();
    }

    // ------------------------------------------------------------------------------------------

    public function executeValidate(sfWebRequest $request)
    {
        $id = $request->getParameter('id');
        if ($id)
            $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($id)), sprintf('Object reservation does not exist (%s).', $id));

        $d = array();
        $d['designation'] = $request->getParameter('designation');
        $d['description'] = $request->getParameter('description');
        $d['type'] = $request->getParameter('type');
        if ( $d['type'] == "" ) $d['type'] = "group";

        $d['public_designation'] = '';
        $d['public_description'] = '';
        $d['public'] = $request->getParameter('public') ? 1 : 0;
        if ($d['public'])
        {
            $d['public_designation'] = $request->getParameter('public_designation');
            $d['public_description'] = $request->getParameter('public_description');
        }

        switch ($d['type'])
        {
            case 'group' : $d['type_id'] = $request->getParameter('type_group'); break;
            case 'event' : $d['type_id'] = $request->getParameter('type_event'); break;
            default : $d['type_id'] = $request->getParameter('type_user'); break;
        }

        
        // create group if new reservation
        if ( $d['type_id'] == "" && $d['type'] == "group" )
        {
        	$g = new Groups();
        	$g->setName($d['designation']);
        	$g->save();
        	$d['type_id'] = $g->getId();

        }
        
        if ($id)
            $this->update('Reservation', $d, $id);
        else
        {
           //$this->insert('Reservation', $d);
           $r = new Reservation();
           $r->setDesignation($d['designation']);
           $r->setDescription($d['description']);
           $r->setType($d['type']);
           $r->setTypeId($d['type_id']);
           $r->setPublic($d['public']);
           $r->setPublicDesignation($d['public_designation']);
           $r->setPublicDescription($d['public_description']);
           $r->save();
        	
           $request->setParameter('id',$r->getId());
        }

        $this->startdate = $request->getParameter('startdate');
        $this->stopdate = $request->getParameter('stopdate');
        
        if ( ! $request->getParameter('ajax') )
        	$this->redirect('reservation/list');
        else
        {
        	if ( $id )
        		$this->executeAjaxDetailedReservation($request);
        	else
        		$this->executeAjaxAddPeriod($request);
        }
    }

    // ------------------------------------------------------------------------------------------

    public function executeDelete(sfWebRequest $request)
    {
        $reservation_id = $request->getParameter('id');
        $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        Doctrine_Query::create()
            ->delete('ReservationComputer rc')
            ->where('rc.reservation_id = ?', $reservation_id)
            ->execute();

        Doctrine_Query::create()
            ->delete('ReservationRoom rr')
            ->where('rr.reservation_id = ?', $reservation_id)
            ->execute();

        Doctrine_Query::create()
            ->delete('Reservation r')
            ->where('r.id = ?', $reservation_id)
            ->execute();

        // delete group if group
        $type = $reservation->getType();
        if ( $type == "group" )
        {
        	$group_id = $reservation->getTypeId();
        	
        	Doctrine_Query::create()
        		->delete('Groups g')
        		->where('g.id = ?', $group_id)
        		->execute();
        }
        
        if ( $request->getParameter('ajax') )
        	$this->setTemplate('AjaxDelete','reservation');
        else
        	$this->redirect("reservation/list");
    }

    // ------------------------------------------------------------------------------------------

    public function executeEvents(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('events');

        $this->events = Doctrine::getTable('Event')
            ->createQuery('e')
            ->orderBy('e.designation')
            ->execute();
    }

    // ------------------------------------------------------------------------------------------

    public function executeFormevent(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('events');

        $event_id = $request->getParameter('id');
        if ($event_id)
        {
            $this->forward404Unless($event = Doctrine::getTable('Event')->find(array($event_id)), sprintf('Object event does not exist (%s).', $event_id));
            $this->event = $event;
        }

        $this->reservations = Doctrine::getTable('Reservation')
            ->createQuery('r')
            ->orderBy('r.designation')
            ->execute();
    }

    // ------------------------------------------------------------------------------------------

    public function executeValidateevent(sfWebRequest $request)
    {
        $event_id = $request->getParameter('id');
        if ($event_id)
        {
            $this->forward404Unless($event = Doctrine::getTable('Event')->find(array($event_id)), sprintf('Object event does not exist (%s).', $event_id));
            $this->event = $event;
        }

        $reservation_id = $request->getParameter('reservation_id');
        if ($reservation_id)
            $this->forward404Unless(Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        $d = array();
        $d['designation'] = $request->getParameter('designation');
        $d['description'] = $request->getParameter('description');
        $d['reservation_id'] = $reservation_id;

        if ($event_id)
            $this->update('Event', $d, $event_id);
        else
            $this->insert('Event', $d);

        $this->redirect("reservation/events");
    }

    // ------------------------------------------------------------------------------------------

    public function executeDeleteevent(sfWebRequest $request)
    {
        $event_id = $request->getParameter('id');
        if ($event_id)
            $this->forward404Unless($event = Doctrine::getTable('Event')->find(array($event_id)), sprintf('Object event does not exist (%s).', $event_id));

        Doctrine_Query::create()
            ->delete('Event e')
            ->where('e.id = ?', $event_id)
            ->execute();

        $this->redirect("reservation/events");
    }

    // ------------------------------------------------------------------------------------------

    public function executePeriods(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('list');

        $reservation_id = $request->getParameter('id');
        $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        $this->reservation = $reservation;

        $this->computer_reservations = Doctrine::getTable('ReservationComputer')
            ->createQuery('rc')
            ->leftJoin('rc.Computer c')
            ->addWhere('rc.reservation_id = ?', $reservation_id)
            ->orderBy('rc.start_date')
            ->execute();

        $this->room_reservations = Doctrine::getTable('ReservationRoom')
            ->createQuery('rr')
            ->leftJoin('rr.Room r')
            ->addWhere('rr.reservation_id = ?', $reservation_id)
            ->orderBy('rr.start_date')
            ->execute();
    }

    // ------------------------------------------------------------------------------------------

    public function executeAddperiod(sfWebRequest $request)
    {
        $this->menu = $this->getMenu('list');

        $reservation_id = $request->getParameter('id');
        $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        $this->reservation = $reservation;

        $this->computers = Doctrine::getTable('Computer')
            ->createQuery('c')
            ->orderBy('c.name')
            ->execute();

        $this->rooms = Doctrine::getTable('Room')
            ->createQuery('r')
            ->orderBy('r.designation')
            ->execute();
    }

    // ------------------------------------------------------------------------------------------

    public function executeValidateperiod(sfWebRequest $request)
    {
        $reservation_id = $request->getParameter('id');
        $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        $type = $request->getParameter('type');
        $table = 'Reservation'.ucfirst($type);
        $field_id = $type.'_id';

        $d = array();
        $d['reservation_id'] = $reservation_id;
        $d[$field_id] = $request->getParameter('type_'.$type);
        $d['start_date'] = $request->getParameter('formatted_start').' '.$request->getParameter('start_hour').':'.$request->getParameter('start_minute').':00';
        $d['end_date'] = $request->getParameter('formatted_end').' '.$request->getParameter('end_hour').':'.$request->getParameter('end_minute').':00';
        $this->insert($table, $d);

        
        if ( ! $request->getParameter('ajax') )
        	$this->redirect("reservation/periods?id=$reservation_id");
        else
        {
        	$create = $request->getParameter('create');
        	if ( $create == 1 )
        		$this->executeAjaxDetailedReservation($request);
        	else
        		$this->executeAjaxEditPeriod($request);
        }
    }

    // ------------------------------------------------------------------------------------------

    public function executeDeletecomputer(sfWebRequest $request)
    {
        $reservation_id = $request->getParameter('id');
        $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        $reservation_computer_id = $request->getParameter('reservation_computer_id');
        $this->forward404Unless($reservation_computer = Doctrine::getTable('ReservationComputer')->find(array($reservation_computer_id)), sprintf('Object reservation does not exist (%s).', $reservation_computer_id));

        Doctrine_Query::create()
            ->delete('ReservationComputer rc')
            ->where('rc.id = ?',$reservation_computer_id)
            ->execute();

        $this->redirect("reservation/periods?id=$reservation_id");
    }

    // ------------------------------------------------------------------------------------------

    public function executeDeleteroom(sfWebRequest $request)
    {
        $reservation_id = $request->getParameter('id');
        $this->forward404Unless($reservation = Doctrine::getTable('Reservation')->find(array($reservation_id)), sprintf('Object reservation does not exist (%s).', $reservation_id));

        $reservation_room_id = $request->getParameter('reservation_room_id');
        $this->forward404Unless($reservation_room = Doctrine::getTable('ReservationRoom')->find(array($reservation_room_id)), sprintf('Object reservation does not exist (%s).', $reservation_room_id));

        Doctrine_Query::create()
            ->delete('ReservationRoom rc')
            ->where('rc.id = ?',$reservation_room_id)
            ->execute();

        $this->redirect("reservation/periods?id=$reservation_id");
    }

    // ------------------------------------------------------------------------------------------

}
