<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/7
 * Time: 14:59
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Beituijianren extends Model{
    protected $table = 'beituijianren';
    protected $fillable = ['username', 'phone','tuijianren_id'];
    public $timestamps = TRUE;

    protected function getDateFormat() {
        return time();
    }

    protected function asDateTime($value) {
        return $value;
    }
}