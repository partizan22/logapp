<?php

	$title = 'Рух майна підрозділ';
	
?>

<script>
	
	var lang = {
		headers: [
			'Дата запису',
			'Найменування документа',
			'Номер і дата документа',
			//'Постачальник (одержувач)'	
		],
		'name' : 'Найменування',
		'number' : 'Код',
		'unit': 'Од. виміру',
		'price' : 'Ціна',
		'currency' : ' грн',
		'#' : '№',
		'in': 'Над.',
		'out':	'Виб.',
		'total': 'Стан.',
		'date_from': 'від'
	};
	
</script>

<style>
	.h-0 {
		min-width: 100px;
	}
	.h-1 {
		min-width: 120px;
	}
	.h-2 {
		min-width: 100px;
	}
	.h-3 {
		min-width: 100px;
	}
		
	.table-data th{
		text-align: center;
	}
	
	.table-data td{
		text-align: center;
		min-width: 65px;
	}
	
	@media print	{
		
		@page {size: landscape} 
	
		body > :not(.container){
			display: none;
		}
		
		.container {
			margin: 0px;
			width: 100%;
		}
		
	}
	
</style>

<div class="container">

	<div style="height: 20px"></div>
	
	
	
	<table class="table-data" rules="all" border="1">
		<thead>
			
		</thead>
		<tbody>

		</tbody>	
	</table>
	
	<div style="height: 50px"></div>
	
</div>