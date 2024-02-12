<?php

	use Helpers\FormGridHelper;
	
	$document_name = 'Новий акт списання';
	$title = $document_name;

?>

<script>
	var lang = {
		add_subj_title: 'Додати підрозділ в довідник',
		//add_article_title: 'Додати позицію в довідник номенклатури',
		article_search_no_records: 'Нічого не	знайдено.',
		items_no_records: 'Виберіть позиції з довідника номенклатури.'		
	};
	
	var subject_type = 'source';
	
	var items_editable = false;
	var subject_required = false;
	
</script>


<link href="/css/document_form.css" rel="stylesheet" /> 
<link href="/css/select2.min.css" rel="stylesheet" />
<script src="/js/select2.min.js"></script>

<style>
	
	
	#available_items_search_datatable_filter{
			width: 100%;
	} 

	#available_items_search_datatable_filter label{
			width: 100%;
	} 

	#available_items_search_datatable_filter label input{
		width: 100%;
	}
	
	.selected-table tbody td, .selected-table th {
		padding: 3px;
	}
	
	.selected-table td  input {
		width: 90px;
		color: #495057;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: 0.25rem;
		height: 30px;
	}
	
</style>

<div class="container">
	
	<?php FormGridHelper::grid([
		'number' => 'Номер документа',
		'date' => ['Дата документа', 'ad_class' => 'datepicker'],
		'subject_id' => [
			'Кому',
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
	
	<div class="selected-items-container" style="display: none">
		
		<div class="row">
			<h3 class="col-12">Майно до списання:</h3>
		</div>
		
		<table class="table table-striped table-bordered selected-table">
			<thead>
				<tr>
					<th>Підрозділ</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	
		<div class="mb-5" style="text-align: center">
			<button type="submit" class="btn btn-primary" id="btn-submit" style="width: 200px">Зберегти</button>
		</div>
		
		<hr>
	</div>
	
	<div class="row">
		<h3 class="col-12">Вибір позицій:</h3>
	</div>
	
	<table class="available_items_search_datatable" id="available_items_search_datatable">
		<thead>
			<tr>
				<th width="150">Код номенклатури</th>
				<th>Найменування</th>
				<th width="60">Кат.</th>
				<th width="100">Кількіcть</th>
				<th width="100">На складі</th>
				<th width="100">В підрозділах</th>
				<th width="100">Ціна</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
	
	
</div>

<div style="display: none">
	
	<div id="add-subject-dialog">
		<?php FormGridHelper::grid([
			'add-subject-name' => 'Назва підрозділу'
		], [
			'col'
		]) ?>
	</div>

</div>