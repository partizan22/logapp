<?php

namespace Model;

    /**
        * @property int $document_id
        * @property int $book_item_id
		* @property int $category
		* @property int $count  
        */

    class DocumentItemModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'document_item', 
			'fields' => [
				'document_id', 'book_item_id', 'category', 'count' 
			],
			'joins' => [
				'document' => [
					'table' => 'document',
					'on' => "document_item.document_id=document.id"
				],
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
	