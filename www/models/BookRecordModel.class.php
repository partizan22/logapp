<?php

namespace Model;

use Helpers\Arrays;

    /**
        * @property int $document_id
		* @property int $item_id 
        * @property string $type
		* @property int $category
		* @property float $value		 
        */
    class BookRecordModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'book_record', 
			'fields' => [
				'document_id', 'type', 'item_id', 'category', 'update_count', 'value', 'department_id', 'active'
			],
			'joins' => [
				'item' => [
					'table' => 'book_item',
					'on' => "book_record.item_id=item.id"
				],
				'article' => [
					'table' => 'article',
					'on' => "item.article_id=article.id"
				],
				'document' => [
					'table' => 'document',
					'on' => "book_record.document_id=document.id",
				],
				'department' => [
					'table' => 'subject',
					'on' => "book_record.department_id=subject.id",
				],
			]
		];
		
		public static function record($document_id, $item_id, $type, $category, $count, $dep_id=false)
		{
			$ct = $category === 'total' ? \BTF\DB\SQL\SQLExpression::_NULL() : $category;

			$st_r = BookRecordModel::query( Arrays::clear_false(['item_id' => $item_id, 'type' => $type, 'category' => $ct, 'active' => 1, 'department_id' => $dep_id]))
					->single();
			
			if ($st_r)
			{
				$p_count = $st_r->value;
				$st_r->active = 0;
				$st_r->save();
			}
			else
			{
				$p_count = 0.0;
			}

			$r = BookRecordModel::create( Arrays::clear_false([
				'document_id' => $document_id,
				'type' => $type,
				'item_id' => $item_id,
				'category' => $ct,
				'update_count' => $count,
				'value' => $p_count + $count,
				'active' => 1,
				'department_id' => $dep_id
			]));
			$r->save();
		}
		
		public static function refresh($item_id)
		{
			$where_br = $where_di = [];
			if ($item_id === 'all')
			{
				set_time_limit(600);
			}
			else
			{
				$where_br = ['item_id' => $item_id];
				$where_di = ['book_item_id' => $item_id];
			}
			
			\AppGlobal::db()->query( \BTF\DB\SQL\SQLQuery::DELETE('book_record')->where($where_br) );
			
			$items = [];
			foreach (DocumentItemModel::select($where_di) as $i)
			{
				if (!isset($items[ $i->document_id ]))
				{
					$items[$i->document_id] = [];
				}
				if (!isset($items[$i->document_id][ $i->department_id ]))
				{
					$items[$i->document_id][$i->department_id] = [];
				}
				if (!isset($items[$i->document_id][ $i->department_id ][$i->book_item_id]))
				{
					$items[$i->document_id][$i->department_id][$i->book_item_id] = [];
				}
				if (!isset($items[$i->document_id][ $i->department_id ][$i->book_item_id][$i->category]))
				{
					$items[$i->document_id][$i->department_id][$i->book_item_id][$i->category] = ['count' => 0];
				}
				$items[$i->document_id][$i->department_id][$i->book_item_id][$i->category]['count'] += $i->count;
			}
			
			foreach (DocumentModel::query(['account_id' => 3, 'id' => array_keys($items)])
					->order_by('reg_date', 'asc')
					->order_by(\BTF\DB\SQL\SQLExpression::E('CAST(reg_number as UNSIGNED)'), 'asc')
					->order_by('reg_number', 'asc')
					->order_by('sys_order', 'asc')
					->select() as $document )
			{
				$document->set_book_records($items[$document->id]);
			}
			
		}
    }
	