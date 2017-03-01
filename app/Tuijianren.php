<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/7
 * Time: 14:59
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Tuijianren extends Model{
    protected $table = 'tuijianren';
    protected $fillable = ['username', 'phone','password'];
    public $timestamps = TRUE;

    protected function getDateFormat() {
        return time();
    }

    protected function asDateTime($value) {
        return $value;
    }

    public static function tuijianren_validator($request){



          return $validator = \Validator::make($request->input(), [
            'Tuijianren.username' => 'required|min:2|max:20',
            'Tuijianren.phone' => 'required|integer|regex:/^1[34578][0-9]{9}$/',
            'Tuijianren.password' => 'required|alpha_num|between:6,12|confirmed',
            'Tuijianren.password_confirmation' => 'required|between:6,12'
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'max' => ':attribute 长度不符合要求',
            'integer' => ':attribute 必须为整型',
            'regex' => ':attribute 必须合法',
            'between' => ":attribute 长度必须在 :min 和 :max 之间",
            'confirmed' => '密码和确认密码不匹配',
            'alpha_num' => ':attribute 必须是字母或数字'
        ], [
            'Tuijianren.username' => '姓名',
            'Tuijianren.phone' => '电话',
            'Tuijianren.password' => '密码',
            'Tuijianren.password_confirmation' => '确认密码',
        ]);

    }


    public static function beituijianren_validator($request){
       return $validator = \Validator::make($request->input(), [
            'Beituijianren.username' => 'required|min:2|max:20',
            'Beituijianren.phone' => 'required|integer|regex:/^1[34578][0-9]{9}$/',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'max' => ':attribute 长度不符合要求',
            'integer' => ':attribute 必须为整型',
            'regex' => ':attribute 必须合法',
        ], [
            'Beituijianren.username' => '姓名',
            'Beituijianren.phone' => '电话',
        ]);
    }
}