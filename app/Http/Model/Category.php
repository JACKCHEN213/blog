<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected  $primaryKey = "cate_id";
    protected  $table = "category";
    protected  $guarded = [];

    public function tree()
    {
        $cate = Category::orderBy("cate_order", "asc")->get();
        return $this->getTree($cate,'cate_name',  'cate_id', 'cate_pid', 0);
    }

    public function getTree($data, $field_name, $field_id = 'id', $field_pid = 'pid', $pid = 0)
    {
        $arr = array();
        foreach($data as $key=>$value){
            if($value->$field_pid == $pid){
                $data[$key]["_".$field_name] = $data[$key][$field_name];
                $arr[] = $data[$key];
                foreach($data as $m=>$n){
                    if($n->$field_pid == $value->$field_id){
                        $data[$m]["_".$field_name] ="-->>".$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
