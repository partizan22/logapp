<?php

namespace Controller;
use BTF\DB\SQL\SQLExpression;
use Model\PhotoModel;
use Model\PositionsModel;

class ProjectController extends \_Controller{
    
    public function action_get_photos($data){
        
        $rows = PhotoModel::select_where(['project_id' => $data['project_id']]);
        $list = [];
        
        foreach ($rows as $row)
        {
            $data = $row->get_data();
            $size = getimagesize($data['path']);
            $data['w'] = $size[0];
            $data['h'] = $size[1];
            $data['position'] = false;
            $list[$row->id] = $data;
        }
        
        $positions = [];
        foreach (\Model\PositionsModel::select(
                \BTF\DB\SQL\SQLQuery::SELECT()
                ->where(['project_id' => $data['project_id']])
                ->order_by('row', 'asc')
        ) as $row )
        {
            $list[$row->photo_id]['position'] = true;
            $d = $row->get_data();
            $d['row'] = (int)$d['row'];
            $positions[] = $d;
        }
        
        return ['status' => 'ok', 'list' => array_values($list), 'positions' => $positions];
    }
    
    public function action_upload($data){
        $photo = false;
        if (!empty($_FILES))
        {
            $photo = PhotoModel::createNew($_REQUEST['project_id'], $_FILES['file']['tmp_name'], $_FILES['file']['name']);
            $photo->save();
        }
        return $photo ? $photo->get_data() : false;
    }
    
    public function action_set_photo_pos($data) {
        $pos = \Model\PositionsModel::create([
            'photo_id' => $data['photo_id'],
            'project_id' => $data['project_id'],
            'col' => $data['col'],
            'row' => $data['row']
        ]);
        $pos->save();
        
        return ['pos_id' => $pos->id];
    }
    
    public function action_update_crop($data)
    {
        $photo = PhotoModel::select_by_id($data['id']);
        $photo->x1 = $data['x1'];
        $photo->x2 = $data['x2'];
        $photo->y1 = $data['y1'];
        $photo->y2 = $data['y2'];
        $photo->save();
        
        return true;
    }
    
    public function action_update_photo_pos($all_data) 
    {
        
        $new_positions = [];
        
        foreach ($all_data['changes'] as $data)
        {
            $pos = PositionsModel::select_by_id($data['id']);
            $photo = PhotoModel::select_by_id($pos->photo_id);
            
            if (!empty($data['new_row']))
            {
                $project_id = (int)$pos->project_id;
                $row = (int)$data['row'];
                
                $q = \BTF\DB\SQL\SQLQuery::SELECT()
                            ->where("project_id={$project_id}");
                            
                if ($data['direction'] == 'before')
                {
                    $q->where("row < $row")->order_by('row', 'desc');
                }
                else
                {
                    $q->where("row > $row")->order_by('row', 'asc');
                }
                
                $prev_row = PositionsModel::select($q->limit(1));
                if (count($prev_row))
                {
                    $new_row = ($row + $prev_row[0]->row) / 2; 
                }
                else
                {
                    $new_row = ($data['direction'] == 'before') ? ($row / 2) : ($row + 10000);
                }
                
                $data['row'] = $new_row;
            }
            
            
            switch ($data['type'])
            {
                case 'copy':
                    $new_pos = PositionsModel::create([
                        'photo_id' => $pos->photo_id,
                        'project_id' => $pos->project_id,
                        'col' => $data['col'],
                        'row' => $data['row']
                    ]);
                    $new_pos->save();
                    
                    $new_positions[] = $new_pos;
                    break;
                
                case 'update':
                    $pos->row = $data['row'];
                    $pos->col = $data['col'];
                    $pos->save();
                    
                    $new_positions[] = $pos;
                    break;
                
                case 'delete':
                    $pos->delete();
            }
        }
        
        $list = [];
        foreach ($new_positions as $pos)
        {
            $data = ['photo_id' => (int)$pos->photo_id];
            $data['pos_id'] = (int)$pos->id;
            $data['row'] = (int)$pos->row;
            $data['col'] = (int)$pos->col;
            
            $list[] = $data;
        }
        
        return ['status' => 'ok', 'positions' => $list];
    }
    
    
    
}