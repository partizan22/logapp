<?php

	$title = 'Журнал руху майна';
	
?>

<script>
	
	var lang = {
		headers: [
			'Дата запису',
			'Найменування документа',
			'Номер документа',
			'Дата документа',
			'Постачальник (одержувач)',
			'Надійшло',
			'Вибуло'
		],
		'in_book_total' : 'Перебуває згідно з докумен- тами',
		'by_cats' : 'з них за категоріями (сортами)',
		'total' : 'усього',
		'in_starage' : 'на складі',
		'in_departments' : 'у підрозділах',
		'in_departments_h' : 'У тому числі на складі (у підрозділах, військових частинах)'
	};
	
</script>

<style>
	.h-0 {
		min-width: 100px;
	}
	.h-1 {
		min-width: 150px;
	}
	.h-2 {
		min-width: 100px;
	}
	.h-3 {
		min-width: 100px;
	}
	.h-4 {
		min-width: 150px;
	}
	.h-5 {
		min-width: 85px;
	}
	.h-6 {
		min-width: 85px;
	}
	
	.table-data:not(.show-categories) th.h-in_book_total{
		min-width: 85px;
	}
	
	.table-data:not(.show-categories) th.h-in-starage{
		min-width: 85px;
	}
	
	.table-data:not(.show-categories) th.h-in-departments{
		min-width: 85px;
	}
	
	.table-data th{
		text-align: center;
	}
	
	.table-data td{
		text-align: center;
	}
</style>

<div class="container">

	<div style="height: 20px"></div>
	
	<?php  if (!empty($_REQUEST['item_id'])) {
		$item_id = (int)$_REQUEST['item_id'];
	} ?>

	<a href="/document/form/?type=income<?= !empty($item_id) ? "&add_item={$item_id}" : ''  ?>" class="btn"><button class="btn">Нова приходна накладна</button></a>
	<a href="/document/form/?type=internal<?= !empty($item_id) ? "&add_item={$item_id}" : ''  ?>" class="btn"><button class="btn">Нова внутрішня накладна</button></a>
	<a href="/document/form/?type=outcome<?= !empty($item_id) ? "&add_item={$item_id}" : ''  ?>" class="btn"><button class="btn">Нова вихідна накладна</button></a>

	<div style="height: 20px"></div>
	<input type="checkbox" class="show-departments" onchange="draw()"> Показати підрозділи <br />
	<input type="checkbox" class="show-categories"  onchange="draw()"> Показати категорії
	<div style="height: 20px"></div>
	
	<table class="table-data" rules="all" border="1">
		<thead>
			
		</thead>
		<tbody>

		</tbody>	
	</table>
	
	<div style="height: 50px"></div>
	
</div>