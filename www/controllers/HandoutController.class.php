<?php

namespace Controller;
use Model\HandoutModel;
use Model\HandoutMemberModel;
use Helpers\Arrays;

class HandoutController extends \_Controller{

	public function action_index()
	{
		$this->_include_js = ['index.js'];
	}
	
	
	
	public function action_form($request)
	{
		$this->_include_js[] = 'form.js';
		$this->_js_data['numbering_type'] = 'handout';
	}
	
	public function action_create($request)
	{
		$request['document']['date'] = date('Y-m-d', strtotime($request['document']['date']));
		
		
		$model = HandoutModel::create(['account_id' => $this->account_id, 'status' => 'open'] + Arrays::clear_empty($request['document']));
		$model->save();
		
		$model->set_items($request['items']);
		
		
		return ['status' => 'ok', 'id' => $model->id];
	}
	
	public function action_fill($request)
	{
		$this->_include_js[] = 'fill.js';
		$this->_js_data['id'] = $request['id'];
	}
	
	public function action_get_document($request)
	{
		$document = HandoutModel::query()->by_id($request['id']);
		
		$doc_data = $document->get_data();
		if (!empty($doc_data['date']))
		{
			$doc_data['date'] = date('d.m.Y', strtotime($doc_data['date']));
		}
		
		$items = $document->get_items();
		
		$members = [];
		foreach (\Model\MemberModel::query()->join('handout_members')->select() as $m)
		{
			$row = $m->get_data();
			$row['name'] = "{$m->lastname} {$m->firstname} {$m->fathername}";
			$members[] =  $row;
		}
				
		return [
			'status' => 'ok',
			'document' => $doc_data,
			'items' => $items,
			'members' => $members,
		];
	}
	
	public function action_get_available_members()
	{
		$data = [];
		foreach (\Model\MemberModel::select(/*['account_id' => $this->account_id]*/) as $m)
		{
			$row = $m->get_data();
			$row['name'] = "{$m->lastname} {$m->firstname} {$m->fathername}";
			$data[] =  $row;
		}
		
		return [
			'status' => 'ok',
			'data' => $data,
		];
	}
	
	public function action_search_members($request)
	{
		$term = $request['term'];
		$h = (int)$request['h'];
		
		$data = [];
		foreach (\Model\MemberModel::query()->left_join('handout_members', "handout_members.handout_id=$h")->where([/*'account_id' => $this->account_id*/ \BTF\DB\SQL\SQLExpression::Like('lastname', "{$term}%")])->fields('handout_members.id hid', false)->select() as $m)
		{
			$row = $m->get_data();
			$row['label'] = "{$m->rank} {$m->lastname} {$m->firstname} {$m->fathername}, {$m->position}";
			$row['name'] = "{$m->lastname} {$m->firstname} {$m->fathername}";
			$row['disabled'] = !empty($row['hid']);
			$data[] =  $row;
		}
		
		echo json_encode(array_values($data));
		exit();
	}
	
	public function action_add_member($request){
		$h = HandoutModel::select_single(['id' => $request['handout_id'], 'account_id' => $this->account_id]);
		
		if ($h)
		{
			$m = HandoutMemberModel::create(['handout_id' => $h->id, 'member_id' => $request['member_id']]);
			$m->save();
			return true;
		}
		
		return false;
	}
	
	public function action_delete_member($request){
		$h = HandoutModel::select_single(['id' => $request['handout_id'], 'account_id' => $this->account_id]);
		
		if ($h)
		{
			$m = HandoutMemberModel::select_single(['handout_id' => $h->id, 'member_id' => $request['member_id']]);
			$m->delete();
			return true;
		}
		
		return false;
	}
	
	public function action_get_members($request)
	{
		$data = [];
		foreach (\Model\MemberModel::query()->join('handout_members')->select() as $m)
		{
			$row = $m->get_data();
			$row['name'] = "{$m->lastname} {$m->firstname} {$m->fathername}";
			$data[] =  $row;
		}
		
		return [
			'status' => 'ok',
			'data' => $data,
		];
	}
	
	public function action_export($request)
	{
		$document = HandoutModel::query()->by_id($request['id'], [/*'account_id' => $this->account_id*/]);
		$items = $document->get_items();
				
		$members = [];
		foreach (\Model\MemberModel::query()->join('handout_members')->select() as $m)
		{
			$row = $m->get_data();
			$row['name'] = "{$m->lastname } " . mb_substr($m->firstname, 0, 1) . ' ' . mb_substr($m->fathername, 0, 1);
			$members[] =  $row;
		}
		
		$filename = "роздавалка_{$document->number}_{$document->date}.xlsx";
		include "./docforms/handout.php";
		
	}
}