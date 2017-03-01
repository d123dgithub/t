<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/20
 * Time: 10:34
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Szm extends Model
{

    protected $table = 'szm';
    protected $fillable = ['username', 'phone', 'shop','order_time','money','tuijianren','szm','commission'];
    public $timestamps = TRUE;

    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;

    }


    public static function total($id='',$who=''){
        if($id && $who){
            //总金额
            $data['money'] =self::where(array($who => $id))->sum('money');
            //总成交
            $data['szmno'] = self::where(array($who => $id))->count();
            //总佣金
            $data['commission'] =self::where(array($who => $id))->sum('commission');
            //已结佣金
            $data['commission1'] =self::where(array($who => $id,'is_over' => 1))->sum('commission');
            //未结佣金
            $data['commission0'] = self::where(array($who => $id,'is_over' => 0))->sum('commission');
        }else{
            //总金额
            $data['money'] =self::sum('money');
            //总成交
            $data['szmno'] = self::count();
            //总佣金
            $data['commission'] =self::sum('commission');
            //已结佣金
            $data['commission1'] =self::where(array('is_over' => 1))->sum('commission');
            //未结佣金
            $data['commission0'] = self::where(array('is_over' => 0))->sum('commission');
        }
        return $data;
    }


}