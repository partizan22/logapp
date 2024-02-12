<?php

namespace Model;

    /**
        * @property string $name        
        */
    class SubjectModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'subject', 
			'fields' => [
				'name'
			],
			'joins' => [
				'account_rel' => [
					'table' => 'account_subject_rel',
					'on' => "account_rel.subject_id=subject.id"
				]
			]
		];
    }
	