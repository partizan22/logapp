<?php

	namespace Helpers;
	
	class Arrays
	{
		
		public static function clear_false($array)
		{
			$result = [];
			foreach ($array as $key=>$val)
			{
				if ($val === false)
				{
					continue;
				}
				
				if (is_array($val))
				{
					$val = self::clear_false($val);
				}
				
				$result[$key] = $val;
			}
			return $result;
		}
		
		public static function clear_empty($array)
		{
			$result = [];
			foreach ($array as $key=>$val)
			{
				if (($val === false) || ($val === ''))
				{
					continue;
				}
				
				if (is_array($val))
				{
					$val = self::clear_false($val);
				}
				
				$result[$key] = $val;
			}
			return $result;
		}
		
	}