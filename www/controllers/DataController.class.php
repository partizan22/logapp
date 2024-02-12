<?php

namespace Controller;
use Model\SubjectModel;
use Model\ArticleModel;
use Model\BookItemModel;
use BTF\DB\SQL\SQLExpression;

class DataController extends \_Controller{
    
    public function action_subjects($request)
	{
		$q = !empty($_REQUEST['q']) ? $_REQUEST['q'] : '';
		$rows = SubjectModel::query()->where(SQLExpression::Like('name', "%$q%"))
				->join('account_rel')
				->where("account_rel.account_id={$this->account_id}")
				->where(['rel_type' => explode(',', $_REQUEST['type'])])
				->order_by('name', 'asc')
				->fields('subject.*')
				->limit(20)
				->select();
		
		$data = [];
		foreach ($rows as $r)
		{
			$data[] = [
				'id' => $r->id,
				'text' => $r->name
			];
		}
        
        return ['status' => 'ok', 'results' => $data];
    }
	
	public function action_create_subject($data)
	{
		$subject = SubjectModel::create(['name' => $data['name']]);
		$subject->save();
		\AppGlobal::db()->query(
			\BTF\DB\SQL\SQLQuery::INSERT('account_subject_rel')->set([
				'account_id' => $this->account_id,
				'subject_id' => $subject->id,
				'rel_type' => $data['type']
			])
		);
		
		return ['status' => 'ok', 'subject' => $subject->get_data()];
	}
	
	public function action_articles($request)
	{
		$q = '';
		$rows = ArticleModel::query()/*->where(SQLExpression::Like('name', "%$q%"))*/
				->order_by('name', 'asc')
				->limit(1000)
				->select();
		
		$data = [];
		foreach ($rows as $r)
		{
			$data[] = $r->get_data();
		}
        
        return ['status' => 'ok', 'data' => $data];
	}
	
	public function action_get_article($request)
	{
		$art = ArticleModel::query()->by_id($request['id']);
		//$art = ArticleModel::query()->select();
		$last_item = BookItemModel::query(['article_id' => $art->id])
				->order_by('id', 'desc')
				->single();
		
		$data = $art->get_data() + ['price' => ''];
		if ($last_item)
		{
			$data['price'] = $last_item->price;
		}
		
		return ['status' => 'ok', 'data' => $data];
	}
	
	public function action_create_article($data)
	{
		$article = ArticleModel::create($data);
		$article->save();
		
		return ['status' => 'ok', 'article' => $article->get_data() + ['price' => '']];
	}
    
}