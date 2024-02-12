<?php

namespace Model;

    /**
        * @property string $name
        * @property string $number
        * @property bool $is_cat
        */
    class ArticleModel extends \_Model
    {   
        protected static $__scheme = ['table_name' => 'article', 'fields' => [
            'name', 'number', 'is_cat', 'unit',
        ]];
    }
	