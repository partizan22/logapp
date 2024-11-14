<?php

	use Helpers\FormGridHelper;
	
	$document_name = 'Нова внутрішня здавальна накладна';
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
	var from_department  = 'subject';
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
		'subject_id' => [
			'Підрозділ',
			'type' => 'select',
			'ad_class' => 'subject-select',
			'render' => function($item){
				?>
					<div class="input-group" id="subject-select-group">
						<select name="<?= $item['name'] ?>" class="form-control <?= $item['ad_class'] ?>"></select>
						<div class="input-group-append">
						  <button class="btn btn-info" id="btn-add-subject" type="button">+</button>
						</div>
					</div>
				<?php
			}
		]
	], [
		'col-12 col-sm-6', '*', 'col'
	]) ?>
	
	<hr>
	
	<div id="doc-items-container"> 
	
		<table class="doc-items-table" id="doc-items-table" style="width: 100%">
			<thead>
				<tr>
					<th width="165">Код номенклатури</th>
					<th>Найменування</th>
					<th width="60">Кат.</th>
					<th width="100">Кількіcть</th>
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
	
	<div id="add-subject-dialog">
		<?php FormGridHelper::grid([
			'add-subject-name' => 'Назва підрозділу'
		], [
			'col'
		]) ?>
	</div>


	<div id="add-article-dialog">
		<?php FormGridHelper::grid([
			'add-article-name' => 'Найменування',
			'add-article-number' => 'Код номенклатури',
			'add-article-unit' => 'Одиниця виміру',
			'add-article-is_cat' => [
				'Тип майна',
				'type' => 'select',
				'options' => [
					'' => '',
					1 => 'Категорійне',
					0 => 'Некатегорійне'
				]
			]
		], [
			'col-sm-12', 'col-6', '*', 'col-sm-12' 
		]) ?>
		
		<?php /*
		<div class="form-check">
			<input type="checkbox" class="add-article-is-cal-input" id="add-article-is-cal-input">
			<label class="form-check-label" for="add-article-is-cal-input">Категорійне майно</label>
		</div> */ ?>
		
	</div>
	
</div>