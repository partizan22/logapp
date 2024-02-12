<?php

	class _AjaxCrudController
	{
		/** 
		 * @return \_Model model
		 */
		protected static function model()
		{
			
		}
		
		protected $user_id;

		/** 
		 * @return BTF\Model\DBTableQuery query
		 */
		protected function query($where=false)
		{
			return self::model()->query($where);
		}
		
		protected function 
	}