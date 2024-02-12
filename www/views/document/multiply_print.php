<?php

	$document_name = 'Видавальна накладна';
	$title = $document_name;

?>

<script>
	var lang = {
	};
	
</script>

<style>

	
	/*	body > :not(.print-container){
			display: none;
		}
		
		.print-container{
			display: block;
		} */
	
	@media print	{
	
		body > :not(.print-container){
			display: none;
		}
		
		.print-container{
			display: block;
		}
	
		.print-container > div{
			page-break-after: always;
		}
		
	}
	
	.print-container table{
		    table-layout:fixed;
/*			border-collapse:collapse;
			border-spacing:0;
			border-style:hidden;*/
			border: 1px solid black;
	}
	
	/*
	.print-container table td {
		border: 1px solid black;
	}
	*/
	
	.print-container {
		font-family: "Times New Roman", Times, serif; 
		font-size: 16pt;
		padding-left: 100px;
		padding-right: 50px;
		padding-top: 50px;
	}
	
	.print-h-table td{
		text-align: center;
		padding: 3px;
	}
	
	.print-h-table th{
		font-weight: normal;
		text-align: center;
		padding: 3px;
	}
	
	.print-items-table th{
		font-weight: normal;
		text-align: center;
		padding: 3px;
	}
	
	.print-items-table td{
		text-align: center;
		padding: 3px;
	}
	
	.print-items-table td.l{
		text-align: left;
		padding-left: 5px;
	}
	
	.print-items-table th.r{
		text-align: right;
		padding-right: 5px;
	}
	
	.print-items-table th.vert {
		writing-mode: vertical-lr; 
		transform: rotate(180deg);
		padding: 5px;
	}
	
	.print-container .bb {
		border-bottom: 3px solid black;
	}
	
	.print-container .bl {
		border-left: 3px solid black;
	}
	
	.print-container .br {
		border-right: 3px solid black;
	}
	
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
	
</style>


<div class="print-container">
	
	<div style="text-align: center; font-weight: bold">НАКЛАДНА №  <span data-var="doc_number"></span></div>
	<br />
	<table width="100%" rules="all" class="print-h-table">
		<tr>
			<th width="25%">Реєстраційний номер</th>
			<th width="17%">Номер аркуша</th>
			<th width="17%">Номер документа</th>
			<th width="17%">Дата документа</th>
			<th>Підстава (мета) операції</th>
		</tr>
		<tr>
			<td data-var="doc_number"></td>
			<td>1</td>
			<td  data-var="doc_number"></td>
			<td  data-var="doc_date"></td>
			<td>&nbsp;<br />&nbsp;</td>
		</tr>
	</table>
	<br />
	<table width="100%" rules="all" class="print-h-table">
		<tr>
			<th>Дата операції</th>
			<th width="20%">Служба забезпечення</th>
			<th width="20%">Вантажовідправник</th>
			<th width="20%">Вантажоодержувач</th>
			<th width="26%">Відповідальний одержувач (здавальник)</th>
		</tr>
		<tr>
			<td data-var="doc_date"></td>
			<td>КЕС</td>
			<td>Нач КЕС</td>
			<td  data-var="subject_name"></td>
			<td>&nbsp;<br />&nbsp;</td>
		</tr>
	</table>
	<br />
	<table width="100%" rules="all" class="print-items-table">
		<tr>
			<th width="6%">№ з/п</th>
			<th>Найменування військового майна</th>
			<th width="8%" class="vert">Код номенклатури</th>
			<th width="8%" class="vert">Одиниця виміру</th>
			<th width="8%" class="vert">Категорія</th>
			<th width="8%" class="vert">Видати</th>
			<th width="8%" class="vert">Прийнято</th>
			<th width="20%" class="vert">Примітка</th>			
		</tr>
		<tr class="col-numbers">
			<th>1</th>
			<th>2</th>
			<th class="bb">3</th>
			<th class="bb">4</th>
			<th class="bb">5</th>
			<th class="bb">6</th>
			<th class="bb">7</th>
			<th>8</th>
		</tr>
		<tr class="print-items-table-total">
			<th></th>
			<th class="r">УСЬОГО</th>
			<th data-var="total_items" style="text-align: right; font-weight: bold; border-bottom: 3px solid black; border-left: 3px solid black; border-right: 3px solid black; text-align: left" colspan="5"></th>
			<th></th>
		</tr>
	</table>
	
	<br /><br />
	
	<div class="sign">
		<div>
			Начальник логістики<br />
			капітан
		</div>

		<div>
			Поліщук О.В.
		</div>
	</div>
	
	<div class="sign">
		<div>
			Начальник ФВ<br />
			мл. л-т
		</div>

		<div>
			Василевич Р.А.
		</div>
	</div>
	<br />
	<div class="sign">
		<div>
			Видав (здав): капітан 
		</div>
		<div>
			Ліщук В.М.
		</div>
	</div>
	<br />
	<div class="sign">
		<div>
			Отримав (прийняв): 
		</div>
		<div>
			
		</div>
	</div>
	
</div>
