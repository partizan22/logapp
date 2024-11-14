<?php

use BTF\DB\SQL\SQLQuery;

namespace Model;

    /**
        * @property string $name        
        */
    class HandoutModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'handout', 
			'fields' => [
				'account_id', 'date', 'number', 'status'
			],
		];
		
		public function set_items($items)
		{
			$values = [];
			foreach ($items as $row)
			{
				$item_id = $row['item_id'];
				$price = number_format($row['price'], 4, '.', '');
				$category = !empty($row['category']) ? (int)$row['category'] : 0;
				
				$values[] = '(' . implode(',', [$this->id, $item_id, $price, $category]) . ')';
			}
			\AppGlobal::db()->query( "INSERT INTO handout_items (`handout_id`, `book_item_id`, `price`, `category`) VALUES " . implode(',', $values) );
		}
		
		public function get_items()
		{
			$q = HandoutItemModel::query(['handout_id' => $this->id])
					->join('item')
					->join('article')
					->fields(['handout_items.id', 'handout_items.book_item_id', 'article.id article_id', 'article.unit', 'article.name', 'article.number', 'category', 'price'])
					->order_by('ord', 'asc');
			$items = \AppGlobal::db()->query($q);
			return $items;					
		}
		
		
    }
	