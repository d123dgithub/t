<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/20
 * Time: 10:34
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{

    protected $table = 'admin';
    protected $fillable = ['username', 'phone', 'password'];
    public $timestamps = TRUE;

    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }


    public static function shop_validator($request)
    {
        return $validator = \Validator::make($request->input(), [
            'Shop.shopname' => 'required|min:1|max:20',
            'Shop.doorno' => 'required|min:1|max:20',
            'Shop.username' => 'required|min:2|max:20',
            'Shop.phone' => 'required|integer|regex:/^1[34578][0-9]{9}$/',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'max' => ':attribute 长度不符合要求',
            'integer' => ':attribute 必须为整型',
            'regex' => ':attribute 必须合法',
            'alpha_num' => ':attribute 必须是字母或数字'
        ], [
            'Shop.username' => '姓名',
            'Shop.shopname' => '商家名称',
            'Shop.doorno' => '门牌号',
            'Shop.phone' => '电话',
        ]);
    }


    public static function szm_validator($request)
    {
        return $validator = \Validator::make($request->input(), [
            'Dj.username' => 'required|min:2|max:20',
            'Dj.shop' => 'required|integer',
            'Dj.phone' => 'required|integer|regex:/^1[34578][0-9]{9}$/',
            'Dj.money' => 'required',
            'Dj.order_time' => 'required',
            'Dj.tuijianren' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'max' => ':attribute 长度不符合要求',
            'integer' => ':attribute 必须为整型',
            'regex' => ':attribute 必须合法',
            'alpha_num' => ':attribute 必须是字母或数字'
        ], [
            'Dj.username' => '被推荐人姓名',
            'Dj.shop' => '商家',
            'Dj.phone' => '被推荐人电话',
            'Dj.money' => '金额',
            'Dj.order_time' => '消费时间',
            'Dj.tuijianren' => '推荐人',
        ]);

    }

    public static function huodong_validator($request)
    {
        return $validater = \Validator::make($request->input(), [
            'Huo.name' => 'required',
            'Huo.username' => 'required|min:1|max:20',
            'Huo.phone' => 'required|integer|regex:/^1[345678][0-9]{9}$/',
            'Huo.open_time' => 'required',
            'Huo.close_time' => 'required',
            'Huo.intro' => 'required',
            'Huo.info' => 'required',
        ], [
            'required' => ':attribute 不能为空',
            'min' => ':attribute 长度不合法',
            'max' => ':attribute 长度不合法',
            'integer' => ':attribute 必须是数字',
            'regex' => ':attribute 不合法',
        ], [
            'Huo.name' => '活动名称',
            'Huo.username' => '活动负责人',
            'Huo.phone' => '负责人电话',
            'Huo.open_time' => '活动开始时间',
            'Huo.close_time' => '活动结束时间',
            'Huo.intro' => '活动介绍',
            'Huo.info' => '活动内容',
        ]);
    }


    public static function admin_validatior($request){
      return  $validator = \Validator::make($request->input(), [
            'Admin.username' => 'required|min:2|max:20',
            'Admin.phone' => 'required|integer|regex:/^1[34578][0-9]{9}$/',
            'Admin.password' => 'required|alpha_num|between:6,12|confirmed',
            'Admin.password_confirmation' => 'required|between:6,12'
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
            'Admin.username' => '姓名',
            'Admin.phone' => '电话',
            'Admin.password' => '密码',
            'Admin.password_confirmation' => '确认密码',
        ]);
    }


}