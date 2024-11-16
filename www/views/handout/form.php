<?php

	use Helpers\FormGridHelper;
	
	$document_name = 'Роздавальна відомість';
	$title = $document_name;

?>

<script>
	var lang = {
		add_subj_title: 'Додати підрозділ в довідник',
		//add_article_title: 'Додати позицію в довідник номенклатури',
		article_search_no_records: 'Нічого не	знайдено.',
		items_no_records: 'Виберіть позиції з довідника номенклатури.'		
	};
	
	var subject_type = 'department';
	var from_department  = 'storage';
	var items_editable = false;
	var subject_required = true;
	
</script>

<link href="/css/document_form.css" rel="stylesheet" /> 
<link href="/css/select2.min.css" rel="stylesheet" />
<script src="/js/select2.min.js"></script>

<div class="container">
	
	<?php FormGridHelper::grid([
		'number' => 'Номер документа',
		'date' => ['Дата документа', 'ad_class' => 'datepicker'],
	], [
		'col-12 col-sm-6', '*'
	]) ?>
	
	<hr>
	
	<div class="row">
		<h3 class="col-12">Вибрані позиції:</h3>
	</div>
	
	<div id="doc-items-container"> 
	
		<table class="doc-items-table" id="doc-items-table" style="width: 100%">
			<thead>
				<tr>
					<th width="165">Код номенклатури</th>
					<th>Найменування</th>
					<th width="60">Кат.</th>
					<th width="100">Ціна</th>
					<th width="50"></th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		
		<hr>
	</div>
	
	<div class="row">
		<h3 class="col-12">Пошук позицій:</h3>
	</div>
	
	<table class="available_items_search_datatable" id="available_items_search_datatable">
		<thead>
			<tr>
				<th width="150">Код номенклатури</th>
				<th>Найменування</th>
				<th width="60">Кат.</th>
				<th width="100">Кількіcть</th>
				<th width="100">Ціна</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
	
	<hr>
	
	<div class="mb-5" style="text-align: center">
		<button type="submit" class="btn btn-primary" id="btn-submit" style="width: 200px">Зберегти</button>
	</div>
	
	
</div>

<div style="display: none">
	
	
	
</div>