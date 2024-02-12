<?php

namespace Controller;
use Model\DocumentModel;
use Model\DocumentItemModel;
use BTF\DB\SQL\SQLExpression;
use Helpers\Arrays;

class DocumentController extends \_Controller{

	public function action_index()
	{
		$this->_include_js = ['index.js'];
	}
	
	public function action_get_index()
	{
		$data = [];
		$id = [];
		foreach (DocumentModel::query()
				->left_join('subject')
				->fields('subject.name subject_name', false)
				->where(['account_id' => $this->account_id])->select() as $row)
		{
			$r = $row->get_data() + ['items' => []];
			
			if ($row->type == 'internal')
			{
				$r['reg_date'] = $row->date;
				$r['reg_number'] = $row->number;
			}
			
			$data[$row->id] = $r;
			$id [] = $row->id;
		}
		
		foreach (DocumentItemModel::query(['document_id' => $id])
				->join('item')
				->join('article')
				->group_by(['document_id', 'article.id'])
				->fields(['document_id', 'article.id', 'article.name', 'sum(document_item.count) cnt'])
				->select() as  $item )
		{
			$data[$item->document_id]['items'][] = $item->get_data();
		}
		
		return ['status' => 'ok', 'items' => array_values($data)];
	}
	
	public function action_form($request)
	{
		$type = $request['type'];
		
		if (!DocumentModel::is_valid_type($type))
		{
			return false;
		}
		
		$this->_include_js[] = 'form.js';		
		$this->_js_data['document_type'] = $type;
		
		$type = DocumentModel::_type($type);
		
		$this->_view_name = "{$type}_form";
		
		if (method_exists($this, "action_form_{$type}"))
		{
			$result = call_user_func([$this, "action_form_$type"], $request);
		}
	}
	
	public function action_writeoff_form($request)
	{
		$this->_include_js[] = 'writeoff_form.js';	
		
		$type = 'writeoff';
		$this->_js_data['document_type'] = $type;		
		$type = DocumentModel::_type($type);
		
		$this->_view_name = "{$type}_form";
	}
	
	public function action_view($request)
	{
		$document = DocumentModel::query()->by_id($request['id']);
		
		$type = $document->type;
		$this->_js_data['document_type'] = $type;
		
		$type = DocumentModel::_type($type);
		$this->_include_js[] = 'view.js';	
		$this->_view_name = "{$type}_view";
		
		$this->_js_data['document_id'] = $document->id;
	}
	
	public function action_multiply_print($request)
	{	
		$this->_include_js[] = 'multiply_print.js';	
		$this->_view_name = "multiply_print";
		$this->_js_data['document_ids'] = [553,554,555,556,557,558,559,560,561,562,563,564,565,566,567,568,569,570,571];
	}
	
	public function action_get_documents($request)
	{
		$result = [
			'status' => 'ok',
			'documents' => [],
		];
		foreach ([553,554,555,556,557,558,559,560,561,562,563,564,565,566,567,568,569,570,571] as $id)
		{
			$doc = $this->action_get_document(['id' => $id]);
			$result['documents'][] = $doc;
		}
		
		return $result;
	}
	
	public function action_get_document($request)
	{
		$document = DocumentModel::query()->by_id($request['id']);
		
		if (($document->subject_id))
		{
			$subject = \Model\SubjectModel::query()->by_id($document->subject_id)->get_data();
		}
		else
		{
			$subject = false;
		}
		$items = $document->get_items();
		
		$doc_data = $document->get_data();
		if (!empty($doc_data['date']))
		{
			$doc_data['date'] = date('d.m.Y', strtotime($doc_data['date']));
		}
		if (!empty($doc_data['reg_date']))
		{
			$doc_data['reg_date'] = date('d.m.Y', strtotime($doc_data['reg_date']));
		}
		
		$n = count($items);
				
		return [
			'status' => 'ok',
			'document' => $doc_data,
			'subject' => $subject,
			'items' => $items,
			'total_items' => $n . ' (' . \Helpers\NumbersLangHelper::lang_number($n, 'md') . ') найменуван' . \Helpers\NumbersLangHelper::num_ending($n, 'ня', 'ня', 'ь', 'md')
		];
	}
	
	public function action_create($request)
	{
		$type = $request['type'];
		
		if (!DocumentModel::is_valid_type($type))
		{
			return false;
		}
		
		if (!empty($request['document']['reg_date']))
		{
			$request['document']['reg_date'] = date('Y-m-d', strtotime($request['document']['reg_date']));
		}
		
		if (!empty($request['document']['date']))
		{
			$request['document']['date'] = date('Y-m-d', strtotime($request['document']['date']));
		}
		
		$document = DocumentModel::create(['type' => $type, 'account_id' => $this->account_id] + Arrays::clear_empty($request['document']));
		$document->save();
		
		$document->set_items($request['items']);
		return ['status' => 'ok', 'document' => $document->get_data()];
	}
	
	public function action_get_number($request)
	{
		$y = date('Y');
		$document = DocumentModel::query()->where([
			'account_id' => $this->account_id, 
			'type' => $request['type'],
			"`date` >= '$y-01-01'"
		])->order_by(SQLExpression::E('CAST(reg_number as unsigned)'), 'desc')->limit(1)->single();
		
		return [
			'status' => 'ok',
			'number' => 1 + (int)($document ? $document->reg_number : 0),
		];
	}
	
	public function action_word_export($request)
	{
		$document = DocumentModel::query()->by_id($request['id']);
		$type = DocumentModel::_type($document->type);
		
		$form = "./docforms/{$type}.php";
		
		if (!file_exists($form))
		{
			return;
		}
		
		$data = $this->action_get_document($request);
		
		include $form;
		
		header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
		header ( "Cache-Control: no-cache, must-revalidate" );
		header ( "Pragma: no-cache" );
		header ( "Content-type: application/vnd.ms-word" );
		header ( "Content-Disposition: attachment; filename={$name}.docx" );
		
		error_reporting(0);
		
		$file = $processor->save();
		readfile($file);
		exit();
	}
    
}