<?php

	$title = 'Документи';
	
?>

<script>
	var names = document_names;
	
	var type_tabs = [
		null,
		{
			title: 'Вхідні накладні',
			types: ['income']
		},
		{
			title: 'Акти прийм.-передачі',
			types: ['income_act']
		},
		{
			title: 'Внутрішні накладні',
			types: ['internal', 'internal_return']
		},
		{
			title: 'Вихідні накладні',
			types: ['outcome']
		},
		{
			title: 'Акти списання',
			types: ['write_off']
		}
	];
		
	
	
</script>

<style>
	
.items_datatable tr{
        cursor: pointer;
}

ul.nav-tabs a.nav-link{
	font-weight: bold;
}

.items_datatable td ul{
	margin: 0px;
	padding: 0px;
}

.items_datatable td ul>li {
	list-style: none;
	font-size: 0.75em;
}

</style>

<div class="container">

	<div style="height: 20px"></div>

	
	<a href="/document/form/?type=income" class="btn"><button class="btn">Створити приходну накладну</button></a>
	<a href="/document/form/?type=internal" class="btn"><button class="btn">Створити внутрішню накладну</button></a>
	<a href="/document/form/?type=outcome" class="btn"><button class="btn">Створити вихідну накладну</button></a>
	
	<div style="height: 20px"></div>

	
	<h2>Журнал документів</h2>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#">Всі</a>
		</li>
	</ul>
	
	<div style="height: 20px"></div>
	
	<table class="items_datatable table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>Реєстр. №</th>
				<th>Дата реєстр.</th>
				<th>Найменування док-та</th>
				<th>№ док-та</th>
				<th>Дата док-та</th>
				<th>Від кого/ кому</th>
				<th>Майно</th>
			</tr>
		</thead>
		<tbody>

		</tbody>	
	</table>
	
	<div style="height: 50px"></div>
	
</div>