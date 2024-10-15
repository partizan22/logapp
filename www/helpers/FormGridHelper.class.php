<?php

	namespace Helpers;
	
	class FormGridHelper
	{
		protected $items;
		protected $index = 0;


		public function __construct($items) 
		{
			$this->items = [];
			foreach ($items as $key => $val)
			{
				if (!is_array($val))
				{
					$val = ['title' => $val];
				}
				
				if (!isset($val['title']) && isset($val[0]))
				{
					$val['title'] = $val[0];
				}
				
				if (!isset($val['name']))
				{
					$val['name'] = $key;
				}
				
				$this->items[] = $val;
			}
		}


		public static function grid($items, $grids) 
		{
			$inst = new self($items);
			$inst->recursive_output($grids);
		}
		
		public function recursive_output($grids, $parent_class='')
		{
			echo "<div class='$parent_class row'>";
			
			$prev_class = '';
			foreach ($grids as $c)
			{
				if (is_array($c))
				{
					$class = $c[0];
					unset($c[0]);
					$this->recursive_output($c, $class == '*' ? $prev_class : $class);
				}
				else
				{
					$class = $c;
					$this->output_item($class == '*' ? $prev_class : $class);
				}
				
				if ($class !== '*')
				{
					$prev_class = $class;
				}
			}
			
			echo '</div>';
		}
		
		public function output_item($class)
		{
			$item = $this->items[$this->index ++];
			$d = '';
			if (!empty($item['desc']))
			{
				$d = "<small class=\"form-text text-muted\">{$item['desc']}.</small>";
			}
			
			echo "<div class='form-group {$class}'>
				<label >{$item['title']}:</label>
				";
				$this->input($item);
			echo "$d
			</div>";
		}
		
		protected function input($item)
		{
			$item += [
				'type' => 'text_input',
				'ad_class' => '',
			];
			
			if (isset($item['render']))
			{
				return call_user_func($item['render'], $item);
			}
			
			return $this->{$item['type']}($item);
		}
		
		protected function text_input($item)
		{
			echo "<input type='text' name='{$item['name']}' class='form-control {$item['ad_class']}'>";
		}
		
		protected function select($item)
		{
			if (isset($item['options_t']))
			{
				$item['options'] = [];
				foreach ($item['options_t'] as $t)
				{
					$item['options'][$t] = $t;
				}
			}
			$item += ['options' => []];
			
			echo "<select name='{$item['name']}' class='form-control {$item['ad_class']}'>";
			foreach ($item['options'] as $name => $title)
			{
				echo "<option value='$name'>$title</option>";
						
			}
			echo "</select>";
		}
		
		protected function button($item)
		{
			
		}
		
		
		
		
		
	}