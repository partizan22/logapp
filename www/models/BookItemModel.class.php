<?php

namespace Model;

    /**
        * @property int $article_id
		* @property int $account_id 
        * @property float $price
        */
    class BookItemModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'book_item', 
			'fields' => [
				'article_id', 'price', 'account_id'
			],
			'joins' => [
				'article' => [
					'table' => 'article',
					'on' => "book_item.article_id=article.id"
				]
			]
		];
    }
	