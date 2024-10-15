<?php

	namespace Helpers;
	
	class NumbersLangHelper
	{
		
		public static function lang_number($number, $gend='male')
		{
			if ($number > 999999)
			{
				$m = self::number_with_text((int)($number / 1000000), 'мільйон', '', 'и', 'ів');
				if ($number % 1000000 > 0)
				{
					$m .= ' ' . self::lang_number($number % 1000000, $gend);
				}
				return $m;
			}
			
			if ($number > 999)
			{
				$m = self::number_with_text((int)($number / 1000), 'тисяч', 'я', 'і', '', 'female');
				if ($number % 1000 > 0)
				{
					$m .= ' ' . self::lang_number($number % 1000, $gend);
				}
				return $m;
			}
			
			if ($number > 99)
			{
				$a = ['', "сто", "двісті", "триста", "чотириста", "п’ятсот", "шістсот", "сімсот", "вісімсот", "дев’ятсот"];
				$m = $a[ (int)($number / 100) ];
				if ($number % 100 > 0)
				{
					$m .= ' ' . self::lang_number($number % 100, $gend);
				}
				return $m;
			}
			
			if ($number > 19)
			{
				$a = ['', '', "двадцять", "тридцять", "сорок", "п’ятдесят", "шістдесят", "сімдесят", "вісімдесят", "дев’яносто"];
				$m = $a[ (int)($number / 10) ];
				if ($number % 10 > 0)
				{
					$m .= ' ' . self::lang_number($number % 10, $gend);
				}
				return $m;
			}
			
			if ($number > 2)
			{
				$a = ['', '', '', "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять", "десять", "одинадцять", "дванадцять", "тринадцять", "чотирнадцять", "п'ятнадцять", "шістнадцять", "сімнадцять", "вісімнадцять", "дев'ятнадцять"];
				return $a[$number];
			}
			
			if ($number == 2)
			{
				return $gend === 'female' ? 'дві' : 'два';
			}
			
			if ($number == 1)
			{
				if ($gend === 'male')
				{
					return 'один';
				}
				elseif ($gend == 'female')
				{
					return 'одна';
				}
				else
				{
					return 'одне';
				}
			}
			
			return 'нуль';
		}
		
		public static function num_ending($number, $one, $two, $five)
		{
			$d = $number % 100;
			$s = $number % 10;
			if ((10 < $d) && ($d<20))
			{
				return $five;
			}
			
			if ($s == 1)
			{
				return $one;
			}
			
			if ((1 < $s) && ($s < 5))
			{
				return $two;
			}
			
			return $five;
		}
		
		public static function number_with_text($number, $text, $one, $two, $five, $gend='male')
		{
			return self::lang_number($number, $gend) . ' ' . $text . self::num_ending($number, $one, $two, $five);
		}
		
		public static function lang_price($price)
		{
			$number = number_format($price, 2, '.', '');
			$e = explode('.', $number);
			return self::number_with_text($e[0], '', 'гривня', 'гривні', 'гривень', 'female') . ' ' .
					self::number_with_text((int)$e[1], '', 'копійка', 'копійки', 'копійок', 'female') ;
		}
		
		
		
		
	}