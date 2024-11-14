<?php

use BTF\DB\SQL\SQLQuery;

namespace Model;

    /**
        * @property string $name        
        */
    class MemberModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'member', 
			'fields' => [
				'account_id', 'department', 'firstname', 'lastname', 'fathername'
			],
			'joins' => [
				'handout_members' => [
					'table' => 'handout_members',
					'on' => "handout_members.member_id=member.id"
				]
			]
		];
		
		
    }
	