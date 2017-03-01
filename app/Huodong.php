<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/28
 * Time: 15:24
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Huodong extends Model{
    protected  $table='huodong';
    protected  $fillable=['name','username','phone','intro','info','open_time','close_time','is_delete'];
    public $timestamps=TRUE;
    protected function getDateFormat(){
        return time();
    }

    protected function asDateTime($value){
        return $value;
    }
}