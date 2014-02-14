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
	private function getMenu($actif = 'index')
	{
		$actions = array(
				array('key'=> 'index',     'label' => 'Filters'),
				array('key'=> 'createFilter',       'label' => 'New filter')
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

	public function executeNew(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('index');
		$this->form = new FilterForm();
	}

	public function executeCreateFilter(sfWebRequest $request)
	{
		$this->menu = $this->getMenu('index');
		$listsDetail_query = Doctrine_Query::create()
		->select('lists_id, domain')
		->from('ListsDetail')
		->where('lists_id <= ?', '1');

		$listsDetail_res = $listsDetail_query->fetchArray();

		foreach ($listsDetail_res as $listsDetail)
		{
			if($listsDetail['lists_id'] == 0)
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
		$this->menu = $this->getMenu('index');
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

		if($params['filter_id']==null)
		{
			// On créé un nouveau filtre
			$filter = new Filter();
			$filter->name = $params['filter_name'];
			$filter->description = $params['filter_description'];
			$filter->save();

			// On récupère son ID
			$params['filter_id'] = $filter->id;
		}
		else
		{
			$params['mode'] = 'update';
			
			$sql = <<<SQL
				SELECT ld.id, ld.lists_id
				FROM lists_detail ld
					LEFT JOIN lists li ON ld.lists_id = li.id
					LEFT JOIN lists_filter lf ON li.id = lf.list_id
				WHERE lf.filter_id = '$params[filter_id]'
					AND li.origin = 'SI'
				ORDER BY ld.lists_id
SQL;
		
			$dq = new Doctrine_Query();
			$conn = $dq->getConnection();
			$lists = $conn->fetchAll($sql);
			
			foreach ($lists as $list)
			{
				$sql = <<<SQL
					DELETE FROM lists_detail WHERE id = '$list[id]';
SQL;
				$dq = new Doctrine_Query();
				$conn = $dq->getConnection();
				$conn->execute($sql);
				if($list['lists_id'] != $ancVal)
				{
					$ancVal=$list['lists_id'];
					$sql = <<<SQL
						DELETE FROM lists WHERE id = '$ancVal';
SQL;
					$dq = new Doctrine_Query();
					$conn = $dq->getConnection();
					$conn->execute($sql);
				}
			}
				
			$sql = "UPDATE filter SET name = '$params[filter_name]', description = '$params[filter_description]' WHERE id = '$params[filter_id]';";
			
			$dq = new Doctrine_Query();
			$conn = $dq->getConnection();
			$conn->execute($sql);
			
			$deleteAllListFilter  = Doctrine_Query::create()
			->delete()
			->from('ListsFilter')
			->where('filter_id = ?', $params['filter_id'])
			->execute();
		}

		// On remet à jour les listes globales
		$private_blacklist_content_details = explode("\n", $params['private_blacklist_content']);
		$globale_blacklist_content_details = explode("\n", $params['globale_blacklist_content']);
		$private_whitelist_content_details = explode("\n", $params['private_whitelist_content']);
		$globale_whitelist_content_details = explode("\n", $params['globale_whitelist_content']);

		$listGlobale_whitelist  = Doctrine_Query::create()
		->delete()
		->from('ListsDetail')
		->where('lists_id = ?', 0)
		->execute();

		for($i=0;$i<count($globale_whitelist_content_details);$i++)
		{
			if($globale_whitelist_content_details[$i] != null)
			{
				$insert  = new ListsDetail;
				$insert->domain = $globale_whitelist_content_details[$i];
				$insert->lists_id = 0;
				$insert->save();
			}
		}

		$listGlobale_blacklist  = Doctrine_Query::create()
		->delete()
		->from('ListsDetail')
		->where('lists_id = ?', 1)
		->execute();

		for($i=0;$i<count($globale_blacklist_content_details);$i++)
		{
			if($globale_blacklist_content_details[$i] != null)
			{
				$insert  = new ListsDetail;
				$insert->domain = $globale_blacklist_content_details[$i];
				$insert->lists_id = 1;
				$insert->save();
			}
		}

		// On les attachent au filtre que l'on a créé
		$attach_global_whitelist = new ListsFilter();
		$attach_global_whitelist->list_id = 0;
		$attach_global_whitelist->filter_id = $params['filter_id'];
		$attach_global_whitelist->ordre = 0;
		$attach_global_whitelist->save();

		$attach_global_blacklist = new ListsFilter();
		$attach_global_blacklist->list_id = 1;
		$attach_global_blacklist->filter_id = $params['filter_id'];
		$attach_global_blacklist->ordre = 1;
		$attach_global_blacklist->save();
		
		// On créé une nouvelle liste (whitelist)
		if($params['private_whitelist_content'] != null)
		{
			$whitelist = new Lists();
			$whitelist->name = 'PW' . $params['filter_id'];
			$whitelist->type = 'W';
			$whitelist->origin = 'SI';
			$whitelist->static = '1';
			$whitelist->save();

			$id = $whitelist->id;

			for($i=0;$i<count($private_whitelist_content_details);$i++)
			{
				if($private_whitelist_content_details[$i] != null)
				{
					$insert  = new ListsDetail;
					$insert->domain = $private_whitelist_content_details[$i];
					$insert->lists_id = $whitelist->id;
					$insert->save();
				}
			}

			$attach_whitelist = new ListsFilter();
			$attach_whitelist->list_id = $whitelist->id;
			$attach_whitelist->filter_id = $params['filter_id'];
			$attach_whitelist->ordre = 2;
			$attach_whitelist->save();


		}

		// On créé une nouvelle liste (blacklist)
		if($params['private_blacklist_content'] != null)
		{
			$blacklist = new Lists();
			$blacklist->name = 'PB' . $params['filter_id'];
			$blacklist->type = 'B';
			$blacklist->origin = 'SI';
			$blacklist->static = '1';
			$blacklist->save();

			$id = $blacklist->id;

			for($i=0;$i<count($private_blacklist_content_details);$i++)
			{
				if($private_blacklist_content_details[$i] != null)
				{
					$insert  = new ListsDetail;
					$insert->domain = $private_blacklist_content_details[$i];
					$insert->lists_id = $blacklist->id;
					$insert->save();
				}
			}

			$attach_blacklist = new ListsFilter();
			$attach_blacklist->list_id = $blacklist->id;
			$attach_blacklist->filter_id = $params['filter_id'];
			$attach_blacklist->ordre = 3;
			$attach_blacklist->save();
		}

		// On récupère les listes provenant de Toulouse
		$lists_query = Doctrine_Query::create()
		->select('id')
		->from('Lists')
		->where('origin != ?', 'SI');

		$lists_res = $lists_query->fetchArray();

		foreach ($lists_res as $list)
		{
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

		$id = $request->getParameter('id');

		/*
		$sql = <<<SQL
			SELECT ld.domain, ld.lists_id, lf.ordre
			FROM lists_detail ld
				LEFT JOIN lists li ON ld.lists_id = li.id
				LEFT JOIN lists_filter lf ON li.id = lf.list_id
			WHERE lf.filter_id = '$id'
				AND li.origin = 'SI'
SQL;
		*/
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
				$aaa = $filterT['lists_id'];
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

	}
}