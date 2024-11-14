<?php

namespace Model;

    /**
        * @property int $handout_id
        * @property int $book_item_id
		* @property int $category
        */

    class  HandoutItemModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'handout_items', 
			'fields' => [
				'handout_id', 'book_item_id', 'category', 'ord',
			],
			'joins' => [
				'item' => [
					'table' => 'book_item',
					'on' => "book_item_id=item.id"
				],
				'article' => [
					'table' => 'article',
					'on' => "item.article_id=article.id"
				]
			]
		];
    }
	