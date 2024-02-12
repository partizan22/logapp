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
			$types = ['income', 'internal', 'income_act', 'outcome', 'writeoff'];
			return in_array($type, $types) ? true : false;
		}


		public function set_items($rows)
		{	
			$article_prices_bi = [];
			
			$items = [];
			foreach ($rows as $row)
			{
				$bi = false;
				if (isset($row['item_id']))
				{
					$bi = BookItemModel::query()->by_id($row['item_id']);
					$article_id = $bi->article_id;
					$price = $bi->price;
					$price_k = round(100.0 * $price);
				}
				else
				{
					$article_id = $row['article_id'];
					$price = $row['price'];
					$price_k = round(100.0 * $row['price']);
				}
				
				$category = !empty($row['category']) ? $row['category'] : '';
			
				if (!isset($items[$article_id]))
				{
					$items[$article_id] = [];
					$article_prices_bi[$article_id] = [];
				}
				
				if (!isset($items[$article_id][$price_k]))
				{					
					$items[$article_id][$price_k] = [];
					
					if (!$bi)
					{
						$bi = BookItemModel::query(['article_id' => $article_id, 'price' => $price, 'account_id' => \AppGlobal::$account_id])->single();
					}
					
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
				
				if (isset($items[$article_id][$price_k][$category]))
				{
					$items[$article_id][$price_k][$category]['count'] += $row['count'];
				}
				else
				{
					$items[$article_id][$price_k][$category] = [
						'count' => $row['count'],
						'price' => $price
					];
				}
			}
			
			$book_items = [];
			foreach ($items as $article_id => $ai)
			{
				foreach ($ai as $price_k => $pi)
				{
					$bi_id = $article_prices_bi[$article_id][$price_k];
					$book_items[$bi_id] = ['total' => 0.0];
					foreach ($pi as $category => $i)
					{
						$di = DocumentItemModel::create([
							'document_id' => $this->id, 
							'book_item_id' => $bi_id,
							'count' => $i['count']
						] + ($category ? ['category' => $category] : []) );
						$di->save();
						$book_items[$bi_id]['total'] += $i['count'];
						if ($category)
						{
							$book_items[$bi_id][$category] = $i['count'];
						}
					}
				}
			}
			
			switch (self::_type($this->type))
			{
				case 'income':
					$this->set_income_book_records($book_items, $this->subject_id);
					break;
				
				case 'internal':
					$this->set_internal_book_records($book_items, $this->subject_id);
					break;
				
				case 'outcome':
					$this->set_outcome_book_records($book_items, $this->subject_id);
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
					return 'external';
					
				case 'internal':
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
					
				case 'outcome':
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
	