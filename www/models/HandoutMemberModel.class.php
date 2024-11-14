<?php

namespace Model;

    /**
        * @property int $handout_id
        * @property int $member_id		
        */

    class  HandoutMemberModel extends \_Model
    {   
        protected static $__scheme = [
			'table_name' => 'handout_members', 
			'fields' => [
				'handout_id', 'member_id',
			],
			'joins' => [
				'member' => [
					'table' => 'member',
					'on' => "member_id=member.id"
				]
			]
		];
    }
	