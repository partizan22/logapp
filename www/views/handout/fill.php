<?php

	$document_name = 'Роздавальна відомість';
	$title = $document_name;

?>

<script>
	var lang = {
	};
	
</script>



<style>
	
	.print-container{
		display: none;
	}
	
	
/*		body > :not(.print-container){
			display: none;
		}
		
		.print-container{
			display: block;
		}
	*/

	.sign {
		border-bottom: 1px solid black;
	}
	
	.sign > div {
		display: inline-block;
		width: calc(50% - 5px);
	}
	
	.sign > div:last-child {
		text-align: right;
	}
	
	
	.dochh{
		display: inline-block;
		font-size: 1.1rem;
		font-weight: 400;
		width: 200px;
	}
	
	.dochv{
		display: inline-block;
		font-size: 1.3rem;
		font-weight: 500;
	}
	
	.card {
		padding: 15px;
		margin-bottom: 30px;
	}
	
	.container > h4{
		margin-left: 15px;
	}
	
	#members_datatable_filter{
		width: 100%;
	}
	
	#members_datatable_filter label input {
		width: 100%;
	}
	
	#members_search_input{
		width: 100%;
	}
	
	.table-title{
	
	}
	
	ul.ui-autocomplete > li {
		padding: 1px;
		padding-right: 3px;
		padding-left: 5px;
	}
	
	ul.ui-autocomplete > li:not(.ui-state-disabled):hover {
		background-color: lightcyan;
	}
	
</style>


<div class="container">
	
	<div style="height: 40px"></div>
	
	<div class="card">
		
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="dochh">Номер документа:</div>
				<div class="dochv" data-var="doc_number"></div>
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="dochh">Дата документа:</div>
				<div class="dochv" data-var="doc_date"></div>
			</div>
		</div>
		
	</div>
	
	<div id="doc-items-container"> 
		
		<h3 class="table-title">Вибрані позиції:</h3>
		
		<table class="items_datatable" id="items_datatable" style="width: 100%">
			<thead>
				<tr>
					<th width="165">Код номенклатури</th>
					<th>Найменування</th>
					<th width="60">Кат.</th>
					<th width="100">Ціна</th>
					<th width="50"></th>
					
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		
	</div>
	
	<div style="height: 30px"></div>
	
	<h3>Вибрані о/c:</h3>
	
	<div class="form-group">
		<input type="text" id="members_search_input" class="form-control" />
	</div>
	
	
	<table class="members_datatable" id="members_datatable" style="width: 100%">
		<thead>				
			<tr>
				<th>Посада</th>
				<th>Звання</th>
				<th>ПІБ</th>
				<th width="50"></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	
	
<!--	<div id="members-search-container"> 
	
		<table class="members_datatable" id="members_datatable" style="width: 100%">
			<thead>				
				<tr>
					<th>Посада</th>
					<th>Звання</th>
					<th>ПІБ</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		
	</div>-->
	
	
	<div style="margin-top: 40px; margin-bottom: 40px; text-align: right; ">
		<?php /*
		<button onclick="window.print();" style="width: 150px" class="btn btn-info">Друк</button>
		 */ ?>
	</div>
	
	
	<div style="margin-top: 40px; margin-bottom: 40px; text-align: right; ">
		<a href="#" style="width: 150px; margin-right: 60px" class="btn btn-primary export-link">Завантажити</a> 
		<button onclick="window.print();" style="width: 150px" class="btn btn-info">Друк</button>
	</div>
	
</div>