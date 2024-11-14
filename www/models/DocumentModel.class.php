<?php

namespace Model;

    /**
        * @property string $number
        * @property string $reg_number
		* @property string $date
        * @property string $reg_date
		* @property int $subject_id
		* @property string $type
		* @property string $status
		* @property string $move_type
		* @property string $move_direction
        */
    class DocumentModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'document', 
			'fields' => [
				'account_id', 'number', 'reg_number', 'date', 'reg_date', 'subject_id', 'type', 'form_id', 'status'
			],
			'joins' => [
				'subject' => [
					'table' => 'subject',
					'on' => "subject.id=subject_id"
				]
			]
		];
		
		public static function is_valid_type($type)
		{
			$types = ['income', 'internal', 'internal_return', 'income_act', 'outcome', 'writeoff', 'handout'];
			return in_array($type, $types) ? true : false;
		}


		public function set_items($rows)
		{	
			$article_prices_bi = [];
			
			$items = [];
			foreach ($rows as $row)
			{
				$item_id = false;
				if (isset($row['item_id']))
				{
					//$bi = BookItemModel::query()->by_id($row['item_id']);
					$item_id = $row['item_id'];
				}
				else
				{
					$article_id = $row['article_id'];
					$price = $row['price'];
					$price_k = round(100.0 * $row['price']);
					
					if (!isset($article_prices_bi[$article_id][$price_k]))
					{						
						$bi = BookItemModel::query(['article_id' => $article_id, 'price' => $price, 'account_id' => \AppGlobal::$account_id])->single();
						
						if (!$bi)
						{
							$bi = BookItemModel::create([
								'article_id' => $article_id,
								'price' => $price,
								'account_id' => \AppGlobal::$account_id
							]);
							$bi->save();
						}
						
						$article_prices_bi[$article_id][$price_k] = $bi->id;
					}
					
					$item_id = $article_prices_bi[$article_id][$price_k];
				}
				
				$category = !empty($row['category']) ? $row['category'] : 0;
				$dep_id = !empty($row['dep_id']) ? $row['dep_id'] : 0;
			
				if (!isset($items[$dep_id]))
				{
					$items[$dep_id] = [];
				}
				
				if (!isset($items[$dep_id][$item_id]))
				{
					$items[$dep_id][$item_id] = [];
				}
				
				if (isset($items[$dep_id][$item_id][$category]))
				{
					$items[$dep_id][$item_id][$category]['count'] += $row['count'];
				}
				else
				{
					$items[$dep_id][$item_id][$category] = [
						'count' => $row['count'],
					//	'price' => $price
					];
				}
			}
			
			foreach ($items as $dep_id => $dis)
			{
				foreach ($dis as $item_id => $bis)
				{
					foreach ($bis as $category => $i)
					{
						$di = DocumentItemModel::create([
								'document_id' => $this->id, 
								'book_item_id' => $item_id,
								'count' => $i['count']
							] 
								+ ($category ? ['category' => $category] : [])
								+ ($dep_id ? ['department_id' => $dep_id] : [])
						);
						$di->save();
					}
				}
			}
			
			$this->set_book_records($items);
		}
		
		public function set_book_records($items = false)
		{
			//echo '<pre>';
			//var_dump($items);
			$book_records = [];
			foreach ($items as $dep_id => $dis)
			{
				$book_records[$dep_id] = [];
				foreach ($dis as $item_id => $bis)
				{
					$book_records[$dep_id][$item_id] = ['total' => 0.0];
					foreach ($bis as $category => $i)
					{
						$book_records[$dep_id][$item_id]['total'] += $i['count'];
						if ($category)
						{
							$book_records[$dep_id][$item_id][$category] = $i['count'];
						}
					}
				}
			}
			
			//var_dump($book_records);
			
			//exit();
			
			switch (self::_type($this->type))
			{
				case 'income':
					$this->set_income_book_records($book_records[0], $this->subject_id);
					break;
				
				case 'internal':
					$this->set_internal_book_records($book_records[0], $this->subject_id);
					break;
				
				case 'internal_return':
					$this->set_internal_return_book_records($book_records[0], $this->subject_id);
					break;
				
				case 'outcome':
					$this->set_outcome_book_records($book_records[0], $this->subject_id);
					break;
				
				case 'writeoff':
					$this->set_writeoff_book_records($book_records, $this->subject_id);
					break;
			}
		}


		public function set_income_book_records($book_items, $dep_id)
		{
			foreach ($book_items as $id => $rows)
			{
				foreach ($rows as $category => $count)
				{
					BookRecordModel::record($this->id, $id, 'total', $category, $count);
					BookRecordModel::record($this->id, $id, 'storage', $category, $count);
				}
			}
		}
		
		public function set_outcome_book_records($book_items, $dep_id)
		{
			foreach ($book_items as $id => $rows)
			{
				foreach ($rows as $category => $count)
				{
					BookRecordModel::record($this->id, $id, 'total', $category, -$count);
					BookRecordModel::record($this->id, $id, 'storage', $category, -$count);
				}
			}
		}
		
		public function set_internal_book_records($book_items, $dep_id)
		{
			foreach ($book_items as $id => $rows)
			{
				foreach ($rows as $category => $count)
				{
					BookRecordModel::record($this->id, $id, 'storage', $category, -$count);
					BookRecordModel::record($this->id, $id, 'department', $category, $count, $dep_id);
				}
			}
		}
		
		public function set_internal_return_book_records($book_items, $dep_id)
		{
			foreach ($book_items as $id => $rows)
			{
				foreach ($rows as $category => $count)
				{
					BookRecordModel::record($this->id, $id, 'storage', $category, $count);
					BookRecordModel::record($this->id, $id, 'department', $category, -$count, $dep_id);
				}
			}
		}
		
		public function set_writeoff_book_records($book_items, $dep_id)
		{
			$items_totals = [];
			foreach ($book_items as $dep_id => $d_rows)
			{
				foreach ($d_rows as $id => $rows)
				{
					$add = true;
					if (!isset($items_totals[$id]))
					{
						$items_totals[$id] = $rows;
						$add = false;
					}
					
					foreach ($rows as $category => $count)
					{
						if ($add)
						{
							$items_totals[$id][$category] += $count;
						}
						
						BookRecordModel::record($this->id, $id, 'department', $category, -$count, $dep_id);
					}
				}
			}
			
			foreach ($items_totals as $id => $rows)
			{
				foreach ($rows as $category => $count)
				{
					BookRecordModel::record($this->id, $id, 'total', $category, -$count);					
				}
			}
		}
		
		public function get_items()
		{
			$q = DocumentItemModel::query(['document_id' => $this->id])
					->join('item')
					->join('article')
					->fields(['item.id item_id', 'article.id article_id', 'article.unit', 'article.name', 'article.number', 'category', 'price', 'count']);
			$items = \AppGlobal::db()->query($q);
			return $items;					
		}
		
		protected function _get_move_type()
		{
			switch (self::_type($this->type))
			{
				case 'outcome':
				case 'income':
				case 'writeoff':
					return 'external';
					
				case 'internal':
				case 'internal_return':
					return 'internal';
			}
		}
		
		public function _get_move_direction()
		{
			switch (self::_type($this->type))
			{
				case 'income':
					return 'in';
					
				case 'internal':
					return 'in';
					
				case 'internal_return':
					return 'in';
					
				case 'outcome':
					return 'out';
					
				case 'writeoff':
					return 'out';
			}
		}
		
		public static function _type($type)
		{
			switch ($type)
			{
				case 'income_act':
					return 'income';
					
				default :
					return $type;
			}
		}
		
		public static function _numbering_type($type)
		{
			switch ($type)
			{
				case 'internal_return':
					return 'internal';
					
				default :
					return $type;
			}
		}
		
		/**
		* @return DBTableModel
		*/
	   public static function create($data=[])
	   {
		   if (!isset($data['reg_number']))
		   {
			   $data['reg_number'] = $data['number'];
		   }
		   if (!isset($data['reg_date']))
		   {
			   $data['reg_date'] = $data['date'];
		   }

		   return self::__static_construct($data);
	   }
		
    }
	