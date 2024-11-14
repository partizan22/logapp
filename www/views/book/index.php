<?php

	$title = 'Облік майна';
	
?>

<style>
	
	.items_datatable tr{
        cursor: pointer;
	}

	.items_datatable tr:hover{
			background-color: #f3fff3;		
	}
	
</style>

<div class="container">

	<div style="height: 20px"></div>

	<a href="/document/form/?type=income" class="btn"><button class="btn">Нова приходна накладна</button></a>
	<a href="/document/form/?type=internal" class="btn"><button class="btn">Нова внутрішня накладна</button></a>
	<a href="/document/form/?type=outcome" class="btn"><button class="btn">Нова вихідна накладна</button></a>
	
	<a href="/document/form/?type=writeoff" class="btn"><button class="btn">Новий акт списання</button></a>
	
	<div style="height: 20px"></div>
	
	<div class="checked-item" style="display: none">
		<h4><span class="checked-title"></span> <a href="#">X</a></h4>
	</div>
	
	<table class="items_datatable">
		<thead>
			<tr>
				<th>Код номенклатури</th>
				<th>Найменування</th>
				<th>Ціна</th>
				<th>Всього на обліку</th>
				<th>На складі</th>
				<th>В підрозділах</th>
			</tr>
		</thead>
		<tbody>

		</tbody>	
	</table>
	
	<div style="height: 50px"></div>
	
</div>