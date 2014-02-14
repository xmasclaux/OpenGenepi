<?php

/**
 * filter actions.
 *
 * @package    GENEPI
 * @subpackage filter
 * @author     Pierre Boitel, Bastien Libersa, Paul PÃ©riÃ©
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class filterActions extends sfActions
{
	
	private function execQuery($sql)
	{
		$dq = new Doctrine_Query();
		$conn = $dq->getConnection();
		return $conn->execute($sql);
	}
	
	private function getMenu($actif = 'index')
	{
		$actions = array(
				array('key'=> 'index',     'label' => 'Filters'),
				array('key'=> 'createFilter',       'label' => 'New filter'),
				array('key'=> 'linkFilter',	'label' => 'Link Filters')
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
	
	private function getInformations()
	{
		$informations = array(
				'wl_helper'=> "Saisissez dans la whiteliste les sites dont vous souhaitez forcer l'autorisation (ou dans la whiteliste globale pour une prise en compte sur tous les filtres). Attention a bien enlever http:// et www du domaine, par exemple pour autoriser http://www.google.fr/ saississez simplement google.fr",
				'bl_helper'=> "Saisissez dans la blackliste les sites dont vous souhaitez forcer l'interdiction (ou dans la blackliste globale pour une prise en compte sur tous les filtres). Attention a bien enlever http:// et www du domaine, par exemple pour bloquer http://www.google.fr/ saississez simplement google.fr",
				'el_helper'=> "Choisissez les listes que vous souhaitez utiliser en blocage pour ce filtre."
				);
		
		return $informations;
	}

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('index');
		
		$filters = Doctrine_Query::create()
		->select('f.name, f.id, f.description')
		->from('Filter f')
		->execute();
		$this->filters = $filters;
	}

	/*
	 public function executeNew(sfWebRequest $request)
	 {
	$this->menu = $this->getMenu('index');
	$this->form = new FilterForm();
	}
	*/

	public function executeCreateFilter(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('createFilter');
		
		$this->informations = $this->getInformations();
		
		$listsDetail_query = Doctrine_Query::create()
		->select('lists_id, domain')
		->from('ListsDetail')
		->where('lists_id <= ?', '2');

		$listsDetail_res = $listsDetail_query->fetchArray();

		foreach ($listsDetail_res as $listsDetail)
		{
			if($listsDetail['lists_id'] == 1)
			{
				$whitelist .= $listsDetail['domain'] . "\n";
			}
			else
			{
				$blacklist .= $listsDetail['domain'] . "\n";
			}
		}
		$this->whitelist = $whitelist;
		$this->blacklist = $blacklist;

		$lists = Doctrine_Query::create()
		->select('l.name, l.id')
		->from('Lists l')
		->where('origin != ?', 'SI')
		->orderBy('name')
		->execute();
		$this->lists = $lists;
	}

	public function executeCreateOkFilter(sfWebRequest $request)
	{

		$this->forward404Unless($request->isMethod('post'));

		// On récupère les informations dont on a besoin dans le formulaire
		$params = array(
				'mode'=> 'create',
				'filter_id'   				   => $request->getPostParameter('id'),
				'filter_name'                  => $request->getPostParameter('form[name]'),
				'filter_description'           => $request->getPostParameter('form[description]'),
				'private_blacklist_content'    => $request->getPostParameter('form[PBlist]'),
				'globale_blacklist_content'    => $request->getPostParameter('form[GBlist]'),
				'private_whitelist_content'    => $request->getPostParameter('form[PWlist]'),
				'globale_whitelist_content'    => $request->getPostParameter('form[GWlist]'),
		);

		// Si le champ 'name' est vide, on arrête le traitement
		if($params['filter_name']==null)
		{
			//return $params;
		}

		// création du filtre s'il n'existe pas
		if($params['filter_id']==null)
		{
			$this->menu = $this->getMenu('createFilter');

			// On créé un nouveau filtre
			$filter = new Filter();
			$filter->name = $params['filter_name'];
			$filter->description = $params['filter_description'];
			$filter->save();

			// On récupère son ID
			$params['filter_id'] = $filter->id;

			// Lien avec liste globales white
			$lfwg = new ListsFilter();
			$lfwg->filter_id = $params['filter_id'];
			$lfwg->list_id = 1;
			$lfwg->ordre = 0;
			$lfwg->save();

			// Lien avec liste global black
			$lfbg = new ListsFilter();
			$lfbg->filter_id = $params['filter_id'];
			$lfbg->list_id = 2;
			$lfbg->ordre = 1;
			$lfbg->save();

			// Création liste SI White du filtre
			$lists = new Lists();
			$lists->name = "PW".$params['filter_id'];
			$lists->type = "W";
			$lists->origin = "SI";
			$lists->static = 0;
			$lists->save();

			$lfwp = new ListsFilter();
			$lfwp->filter_id = $params['filter_id'];
			$lfwp->list_id = $lists->id;
			$lfwp->ordre = 2;
			$lfwp->save();

			// Création liste SI Black du filtre
			$lists = new Lists();
			$lists->name = "PB".$params['filter_id'];
			$lists->type = "B";
			$lists->origin = "SI";
			$lists->static = 0;
			$lists->save();

			$lfbp = new ListsFilter();
			$lfbp->filter_id = $params['filter_id'];
			$lfbp->list_id = $lists->id;
			$lfbp->ordre = 3;
			$lfbp->save();
		}

		// si le filtre existe déjà, simple mise à jour
		else
		{
			$this->menu = $this->getMenu('index');

			$sql = "UPDATE filter SET name = '$params[filter_name]', description = '$params[filter_description]' WHERE id = '$params[filter_id]';";
			$dq = new Doctrine_Query();
			$conn = $dq->getConnection();
			$conn->execute($sql);
		}

		// On remet à jour les listes SI
		$private_blacklist_content_details = explode("\n", $params['private_blacklist_content']);
		$globale_blacklist_content_details = explode("\n", $params['globale_blacklist_content']);
		$private_whitelist_content_details = explode("\n", $params['private_whitelist_content']);
		$globale_whitelist_content_details = explode("\n", $params['globale_whitelist_content']);

		// Mise à jour White liste Globale
		$listGlobale_whitelist  = Doctrine_Query::create()
		->delete()
		->from('ListsDetail')
		->where('lists_id = ?', 1)
		->execute();

		for($i=0;$i<count($globale_whitelist_content_details);$i++)
		{
			if( trim($globale_whitelist_content_details[$i]) != "")
			{
				$insert  = new ListsDetail;
				$insert->domain = trim($globale_whitelist_content_details[$i]);
				$insert->lists_id = 1;
				$insert->save();
			}
		}


		// Mise à jour Black liste Globale
		$listGlobale_blacklist  = Doctrine_Query::create()
		->delete()
		->from('ListsDetail')
		->where('lists_id = ?', 2)
		->execute();

		for($i=0;$i<count($globale_blacklist_content_details);$i++)
		{
			if( trim($globale_blacklist_content_details[$i]) != "")
			{
				$insert  = new ListsDetail;
				$insert->domain = trim($globale_blacklist_content_details[$i]);
				$insert->lists_id = 2;
				$insert->save();
			}
		}


		// Mise à jour White liste Locale
		// Recherche de l'id de la liste
		$lists_query = Doctrine_Query::create()
		->select('id')
		->from('Lists')
		->where('name = ?', 'PW'.$params['filter_id']);
		$lists_res = $lists_query->fetchOne();
		$id_PW = $lists_res['id'];

		// Suppression des détails
		$listLocale_whitelist  = Doctrine_Query::create()
		->delete()
		->from('ListsDetail')
		->where('lists_id = ?', $id_PW)
		->execute();

		for($i=0;$i<count($private_whitelist_content_details);$i++)
		{
			if( trim($private_whitelist_content_details[$i]) != "")
			{
				$insert  = new ListsDetail;
				$insert->domain = trim($private_whitelist_content_details[$i]);
				$insert->lists_id = $id_PW;
				$insert->save();
			}
		}


		// Mise à jour Black liste Locale
		// Recherche de l'id de la liste
		$lists_query = Doctrine_Query::create()
		->select('id')
		->from('Lists')
		->where('name = ?', 'PB'.$params['filter_id']);
		$lists_res = $lists_query->fetchOne();
		$id_PB = $lists_res['id'];

		// Suppression des détails
		$listLocale_blacklist  = Doctrine_Query::create()
		->delete()
		->from('ListsDetail')
		->where('lists_id = ?', $id_PB)
		->execute();

		for($i=0;$i<count($private_blacklist_content_details);$i++)
		{
			if( trim($private_blacklist_content_details[$i]) != "")
			{
				$insert  = new ListsDetail;
				$insert->domain = trim($private_blacklist_content_details[$i]);
				$insert->lists_id = $id_PB;
				$insert->save();
			}
		}


		// Traitement des listes externes (Toulouse)

		// Ajout des liens
		$lists_query = Doctrine_Query::create()
		->select('id')
		->from('Lists')
		->where('origin != ?', 'SI');
		$lists_res = $lists_query->fetchArray();

		$dq = new Doctrine_Query();
		$conn = $dq->getConnection();
		foreach ($lists_res as $list)
		{

			// Suppression de l'ancien lien s'il existe
			$sql  = " delete from lists_filter";
			$sql .= " where list_id = $list[id]";
			$sql .= " and filter_id = $params[filter_id]";
			$conn->execute($sql);

			// Ajout du lien s'il est coché
			if($request->getPostParameter('chBox_' . $list['id']) != null)
			{

				$insert = new ListsFilter();
				$insert->list_id = $list['id'];
				$insert->filter_id = $params['filter_id'];
				$insert->ordre = 4;
				$insert->save();
			}
		}

	}

	public function executeUpdateFilter(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('index');

		$this->informations = $this->getInformations();

		$id = $request->getParameter('id');

		$sql = <<< ENDSQL
			SELECT domain, lists_id, ordre
			FROM lists_filter
			JOIN lists ON lists_filter.list_id = lists.id
			JOIN lists_detail ON lists.id = lists_detail.lists_id
			WHERE lists_filter.filter_id = '$id'
			AND lists.origin = 'SI'
			ORDER BY ordre
ENDSQL;

		$dq = new Doctrine_Query();
		$conn = $dq->getConnection();
		$filters_private_lists_res = $conn->fetchAll($sql);

		foreach ($filters_private_lists_res as $filter)
		{
			if($filter['domain'] != '')
			{
				switch($filter['ordre'])
				{
					case 0 :
						$globale_whitelist .= $filter['domain'] . "\n";
						break;
					case 1 :
						$globale_blacklist .= $filter['domain'] . "\n";
						break;
					case 2 :
						$private_whitelist .= $filter['domain'] . "\n";
						break;
					case 3 :
						$private_blacklist .= $filter['domain'] . "\n";
						break;
					case 4 :
						$other_blacklists[$filter['lists_id']] = $filter['lists_id'];
						break;
				}
			}
		}
		$this->globale_whitelist = $globale_whitelist;
		$this->globale_blacklist = $globale_blacklist;
		$this->private_whitelist = $private_whitelist;
		$this->private_blacklist = $private_blacklist;

		// @TODO  ////////////////////////////////////////////////////////////
		$sql = <<<SQL
			SELECT li.id, li.name, lf.ordre
			FROM lists li
				LEFT JOIN lists_filter lf ON li.id = lf.list_id
			WHERE lf.filter_id = '$id'
				AND li.origin != 'SI'
SQL;
		$dq = new Doctrine_Query();
		$conn = $dq->getConnection();
		$filters_to = $conn->fetchAll($sql);

		foreach ($filters_to as $filterT)
		{
			$aaa = $filterT['id'];
			$other_blacklists[$aaa] = $aaa;
		}
		$this->other_blacklists = $other_blacklists;
		$this->aaa = $filters_to;

		$lists = Doctrine_Query::create()
		->select('l.name, l.id')
		->from('Lists l')
		->where('origin != ?', 'SI')
		->orderBy('name')
		->execute();
		$this->lists = $lists;

		$filters = Doctrine_Query::create()
		->select('name, description, id')
		->from('Filter')
		->where('id = ?', $request->getParameter('id'))
		->execute();
		$this->filters = $filters;
		
		return;
	}

	public function executeDeleteFilter(sfWebRequest $request)
	{
		// On supprime le filtre
		$delete = Doctrine_Core::getTable('Filter')->find($request->getParameter('id'));
		$delete->delete();

		// On récupère les ID de chaque association filtre / listes
		$ListsFilter_que = Doctrine_Query::create()
		->select('list_id')
		->from('ListsFilter l')
		->where('l.filter_id = ?', $request->getParameter('id'));
		$ListsFilter_res = $ListsFilter_que->fetchArray();		
		
		// On supprime les associations filtre / listes
		$delete = Doctrine_Query::create()
		->delete()
		->from('ListsFilter l')
		->where('l.filter_id = ?', $request->getParameter('id'))
		->execute();

		// On récupère les ID de chaque liste associée au filtre que l'on veut supprimer
		foreach ($ListsFilter_res as $ListsFilter)
		{
			if($ListsFilter['list_id'] > 2 && $ListsFilter['list_id'] < 5)
			{
				$delete = Doctrine_Query::create()
				->delete()
				->from('Lists l')
				->where('l.id = ?', $ListsFilter['list_id'])
				->execute();

				// On supprime le détail de chaque liste
				$delete = Doctrine_Query::create()
				->delete()
				->from('ListsDetail l')
				->where('l.lists_id = ?', $ListsFilter['list_id'])
				->execute();
			}
		}

		// On affiche la liste des filtres
		return $this->redirect('filter/index');
	}
	
	public function executeLinkFilter(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('linkFilter');
		
		// recherche des catégorie de public
		$sql = "select ac.id as cat_id, ac.designation, filter_id, name as filter from act_public_category ac left join filter on filter_id = filter.id order by sort_order";
		$this->categorys = $this->execQuery($sql);
		
		
	}
	
	public function executeChangeLinkFilter(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('linkFilter');
		
		$id = $request->getParameter('id');

		$sql = "select * from act_public_category where id = '$id'";
		$this->categorys = $this->execQuery($sql);
		
		$sql = "select * from filter";
		$this->filters = $this->execQuery($sql);
		
	}
	
	public function executeUpdateLinkFilter(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('linkFilter');
		
		$id = $request->getParameter('id');
		$filter_id = $request->getParameter('filter_id');
		
		$sql = "update act_public_category set filter_id = '$filter_id' where id = '$id'";
		$this->execQuery($sql);
		
		$this->redirect('filter/linkFilter');
		
	}
	
	
}