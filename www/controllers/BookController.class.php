<?php

namespace Controller;
use Model\SubjectModel;
use Model\ArticleModel;
use Model\BookItemModel;
use BTF\DB\SQL\SQLExpression;

class BookController extends \_Controller{
	
	public function action_index()
	{
		$this->_include_js = ['index.js'];
	}
	
	public function action_view($request)
	{
		$this->_include_js = ['form46.js'];	
		$this->_view_name = 'form46';
		$this->_js_data = ['item_id' => $request['item_id']];
	}
	
	public function action_get_articles_index($request)
	{
		$q = \Model\BookRecordModel::query()
			->fields([ 'article.id article_id', 'item.id item_id', 'item.price', 'article.number', 'article.name', 'article.is_cat', 'book_record.type', 'book_record.value count'])
			->where([
				"item.account_id={$this->account_id}",
				'active' => 1,
			])
			->where("category IS NULL")
			->where(['type' => ['total', 'storage']])
			->join('item')->join('article');
		
		$rows = \AppGlobal::db()->query($q);
		
		$data = [];
		foreach ($rows as $r)
		{
			$id = $r['item_id'];
			if (!isset($data[$id]))
			{
				$data[$id] = $r + [
					'total_count' => 0.0,
					'storage_count' => 0.0,
				];
			}
			
			$data[$id]["{$r['type']}_count"] += $r['count'];
		}
		
		foreach ($data as &$row)
		{
			$row['department_count'] = $row['total_count'] - $row['storage_count'];
		}
		unset($row);
        
        return ['status' => 'ok', 'items' => array_values($data)];
	}
	
	public function action_get_available_items($request)
	{
		$q = \Model\BookRecordModel::query()
				->fields(['book_record.id record_id', 'item.id item_id', 'article.number', 'article.name', 'article.is_cat', 'item.price', 'book_record.category', 'book_record.value count'])
				->where([
					"item.account_id={$this->account_id}",
					'active' => 1,
					'type' => 'storage',
				])
				->where("((article.is_cat=0) OR (category IS NOT NULL))")
				->where('`value` > 0')
				->join('item')->join('article');
		
		$rows = \AppGlobal::db()->query($q);
		
		$data = [];
		foreach ($rows as $r)
		{
			$data[] = $r;
		}
        
        return ['status' => 'ok', 'data' => $data];
	}
	
	public function action_get_total_available_items($request)
	{
		$q = \Model\BookRecordModel::query()
				->fields(['item.id item_id', 'article.number', 'article.name', 'article.is_cat', 'item.price', 'book_record.category', 'book_record.value count', 'book_record.type', 'book_record.department_id'])
				->where([
					"item.account_id={$this->account_id}",
					'active' => 1,
					'type' => ['storage', 'department', 'total']
				])
				->where("((article.is_cat=0) OR (category IS NOT NULL))")
				->where('`value` > 0')
				->join('item')->join('article');
		
		$rows = \AppGlobal::db()->query($q);
		
		$dep_ids = [];
		$data = [];
		foreach ($rows as $r)
		{
			$item_id = $r['item_id'];
			$cat = !empty($r['category']) ? $r['category'] : 0;
			$r['category'] = $cat;
			
			if (!isset($data[$item_id][$cat]))
			{
				$data[$item_id][$cat] = [
					'count' => 0.0,
					'storage' => 0.0,
					'department' => 0.0,
					'available_by_departments' => [],
					'selected_by_departments' => [],
				] + $r;
			}
			
			$data[$item_id][$cat][ $r['type'] == 'total' ? 'count' :  $r['type'] ] += $r['count'];
			if ($r['type'] == 'department')
			{
				$data[$item_id][$cat]['available_by_departments'][$r['department_id']] = $r['count'];
				$data[$item_id][$cat]['selected_by_departments'][$r['department_id']] = 0.0;
				$dep_ids[$r['department_id']] = $r['department_id'];
			}
		}
		
		$data_values = [];
		foreach ($data as $item_id => $cats)
		{
			foreach ($cats as $cat_id => $row)
			{
				$data_values[] = $row;
			}
		}
		
		$departments = [];
		foreach (\Model\SubjectModel::query(['id' => $dep_ids])->order_by('name', 'asc')->select() as $row )
		{
			$departments[ $row->id ] = $row->name;
		}
        
        return ['status' => 'ok', 'data' => $data_values, 'all_departments' => $departments];
	}
	
	public function action_filter_articles($request)
	{
		$article_id = (int)$request['article_id'];
		$q = \Model\BookRecordModel::query()
			->fields([ 'item.id book_item_id', 'article.number', 'article.name', 'article.is_cat',
						'item.price',
						'book_record.type', 'book_record.value count'])
			->where([
				"item.account_id={$this->account_id}",
				"item.article_id={$article_id}",		
				'active' => 1,
			])
			->where("category IS NULL")
			->where(['type' => ['total', 'storage']])
			->join('item')->join('article');
		
		$rows = \AppGlobal::db()->query($q);
		
		$data = [];
		foreach ($rows as $r)
		{
			$id = $r['book_item_id'];
			if (!isset($data[$id]))
			{
				$data[$id] = $r + [
					'total_count' => 0.0,
					'storage_count' => 0.0,
				];
			}
			
			$data[$id]["{$r['type']}_count"] += $r['count'];
		}
		
		foreach ($data as &$row)
		{
			$row['department_count'] = $row['total_count'] - $row['storage_count'];
		}
		unset($row);
        
		if (count($data) === 1)
		{
			$ids = array_keys($data);
			return ['status' => 'ok', 'single_item' => true, 'book_item_id' => $ids[0]];
		}
		
        return ['status' => 'ok', 'items' => array_values($data)];
	}
	
	public function action_get_form46_data($request)
	{
		$item_id = (int)$request['item_id'];
		
		$q = \Model\BookRecordModel::query()
			->fields([ 'book_record.document_id', 'book_record.type', 'book_record.category', 'book_record.department_id', 'book_record.value count'])
			->where([
				"document.account_id={$this->account_id}",
				"book_record.item_id={$item_id}",
			])->join('document')
						->order_by('book_record.id', 'asc');
		
		$rows = \AppGlobal::db()->query($q);
		
		$empt = ['','','','','',''];
		
		$dep_list = [];
		$data = [];
		$full_total = [0,0,0,0,0,0];
		
		foreach ($rows as $r)
		{
			$id = $r['document_id'];
			$idx = !empty($r['category']) ? $r['category'] : 0;
					
			if (!isset($data[$id]))
			{
				$data[$id] =[
					'document_id' => $id,
					'total' => $empt,
					'storage' => $empt,
					'departments' => [],
					'in' => '',
					'out' => '',
				];
			}
			
			switch ($r['type'])
			{
				case 'total':
					if ($data[$id]['total'][$idx] === '')
					{
						$data[$id]['total'][$idx] = 0.0;
					}
					$data[$id]['total'][$idx] += $r['count'];
					$full_total[$idx] = $r['count'];
					
					break;
				
				case 'storage':
					if ($data[$id]['storage'][$idx] === '')
					{
						$data[$id]['storage'][$idx] = 0.0;
					}
					$data[$id]['storage'][$idx] += $r['count'];
					break;
				
				case 'department':
					
					$dep_id = $r['department_id'];
					if (!isset($data[$id]['departments'][$dep_id]))
					{
						$dep_list[] = $dep_id;
						$data[$id]['departments'][$dep_id] = $empt;
					}
					
					if ($data[$id]['departments'][$dep_id][$idx] === '')
					{
						$data[$id]['departments'][$dep_id][$idx] = 0.0;
					}
					$data[$id]['departments'][$dep_id][$idx] += $r['count'];
					break;
			}
			
			$data[$id]['full_total'] = $full_total;
		}
		
		$dep_list = array_unique($dep_list);
		$doc_list = array_keys($data);
		
		$q = \Model\DocumentModel::query()
				->fields(['document.id', 'subject.name subject_name'], false)
				->fields(['sum(document_item.count) items_count'], false)
				->where(['document.id' => $doc_list])
				->left_join('subject')
				->left_join('document_item', "document_item.document_id=document.id AND document_item.book_item_id={$item_id}")
				->group_by('document.id');
		
		foreach ($q->select() as $row)
		{
			$id = $row->id;
			$doc = $row->get_data();
			
			if (empty($doc['reg_date']))
			{
				$doc['reg_date'] = $doc['date'];
			}
			$data[$id]['dep_total'] = $empt;
			for ($i=0; $i<=5; $i++)
			{
				if ($data[$id]['storage'][$i] !== '')
				{
					$data[$id]['dep_total'][$i] = ($data[$id]['full_total'][$i] - $data[$id]['storage'][$i]); 
				}
			}
			unset($data[$id]['full_total']);
			
			foreach ($dep_list as $dep_id)
			{
				if (!isset($data[$id]['departments'][$dep_id]))
				{
					$data[$id]['departments'][$dep_id] = $empt;
				}
			}
			
			$data[$id]['document'] = $doc;
			
			if ($row->move_type === 'external')
			{
				$data[$id][$row->move_direction] = $row->items_count;
			}
		}
		
		$departments = [];
		
		if (!empty($dep_list))
		{
			foreach (\Model\SubjectModel::query()->where(['id' => $dep_list])->select() as $row)
			{
				$departments[$row->id] = $row->get_data();
			}
		}
		
		return ['status' => 'ok', 'data' => array_values($data), 'departments' => array_values($departments)];
	}
	    
}