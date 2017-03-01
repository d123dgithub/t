<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/7
 * Time: 14:22
 */
namespace App\Http\Controllers;

use App\Beituijianren;
use App\Http\Captcha\CaptchaBuilder;
use App\Szm;
use App\Tuijianren;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TuijianrenController extends Controller
{
    //推广主页
    public function index()
    {
        return view('tuijianren/index');
    }

    public function validate_captcha()
    {
        $userInput = \Request::get('captcha');
        if (Session::get('milkcaptcha') != $userInput) {
            return  true;
        }
        return  false;
    }

    //推荐人注册
    public function register(Request $request)
    {
        $this->user_exit($request);
        if ($request->isMethod('POST')) {
            if($this->validate_captcha()){
                return redirect()->back()->withInput()->with('captcha_error', '验证码错误!');
            }
            $data = $request->input('Tuijianren');
            $tuijianren = DB::table('tuijianren')->where(array('phone' => $data['phone']))->first();
            if ($tuijianren) {
                return redirect()->back()->withInput()->with('is_exist', '该电话号码已存在!');
            }
            $validator = Tuijianren::tuijianren_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['password'] = md5($data['password']);
            if ($tuijianren = Tuijianren::create($data)) {
                Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',推荐人注册(' . $tuijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('tuijianren/login')->with('success', '添加成功!');
            } else {
                return redirect()->back();
            }

        }
        return view('tuijianren/register');
    }


    //推荐人登录
    public function login(Request $request)
    {
        if ($request->session()->has('tuijianren')) {
            return redirect('tuijianren/tuijianren');
        }
        if ($request->isMethod('POST')) {
            if($this->validate_captcha()){
                return redirect()->back()->withInput()->with('captcha_error', '验证码错误!');
            }
            $phone = $request->get('phone');
            $password = md5($request->get('password'));
            $tuijianren = DB::table('tuijianren')->select('id', 'username', 'phone', 'created_at', 'updated_at')->where(array('phone' => $phone, 'password' => $password, 'is_delete' => 0))->first();
            if ($tuijianren) {
                Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',推荐人登录(' . $tuijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
                session(array('tuijianren' => $tuijianren));
                return redirect('tuijianren/tuijianren');
            } else {
                return redirect()->back()->with('error', '登录失败');
            }

        }
        return view('tuijianren/login');
    }

    //登录成功后推荐人主页
    public function tuijianren()
    {
        $tuijianren = Session::get('tuijianren');
        $beituijianrens = DB::table('beituijianren')->where(array('tuijianren_id' => $tuijianren->id))->get();
        foreach ($beituijianrens as &$b) {
            $count = DB::table('szm')->where(array('tuijianren' => $tuijianren->id, 'phone' => $b->phone))->count();
            $money = DB::table('szm')->where(array('tuijianren' => $tuijianren->id, 'phone' => $b->phone))->sum('money');
            $commission = DB::table('szm')->where(array('tuijianren' => $tuijianren->id, 'phone' => $b->phone))->sum('commission');
            $b->count = $count;
            $b->money = $money;
            $b->commission = $commission;
        }
        return view('tuijianren/tuijianren', [
            'beituijianrens' => $beituijianrens,
        ]);
    }

    /**
     * 推荐人的数字码列表
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function  szm(Request $request, $id)
    {
        $szms = DB::table('szm')->where(array('tuijianren' => $id))->paginate(20);
        //统计
        $data = Szm::total($id,'tuijianren');
        $curr_money = $curr_commission0 = $curr_commission1 = 0;
        foreach ($szms as $s) {
            $curr_money += $s->money;
            if ($s->is_over == 0) {
                $curr_commission0 += $s->commission;
            } else {
                $curr_commission1 += $s->commission;
            }
        }
        return view('tuijianren/szm', [
            'szms' => $szms,
            'data'=>$data,
            'curr_money' => $curr_money,
            'curr_commission0' => $curr_commission0,
            'curr_commission1' => $curr_commission1,
        ]);
    }


    //登出
    public function user_exit(Request $request)
    {
        $tuijianren = Session::get('tuijianren');
        if ($tuijianren) {
            Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',推荐人登出(' . $tuijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
        }
        $request->session()->forget('tuijianren');
        return redirect('tuijianren/login');
    }


    public function  add_beituijianren(Request $request)
    {
        $tuijianren = Session::get('tuijianren');
        if ($request->isMethod('POST')) {
            $data = $request->input('Beituijianren');
            $beituijianren = DB::table('beituijianren')->where(array('tuijianren_id' => $tuijianren->id, 'phone' => $data['phone']))->first();
            if ($beituijianren) {
                return redirect()->back()->withInput()->with('is_exist', '该电话号码已存在!');
            }
            $validator = Tuijianren::beituijianren_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['tuijianren_id'] = $tuijianren->id;
            if ($beituijianren = Beituijianren::create($data)) {
                Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',添加被推荐人(' . $beituijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('tuijianren/tuijianren')->with('success', '添加成功!');
            } else {
                return redirect()->back();
            }

        }
        $huodongs = DB::table('huodong')->select(['name', 'intro'])->where('open_time', '<=', time())->where(['is_delete' => 0])->where('close_time', '>=', time())->get();
        $huodong = array();
        if ($huodongs) {
            $huodong = $huodongs[array_rand($huodongs)];
        }

        if ($huodong) {
            $yaoqing = $tuijianren->username . '邀请您参加"' . $huodong->name . '"。' . $huodong->intro;
        } else {
            $yaoqing = $tuijianren->username . '邀请您加入家园佳居皮草城推广活动。';
        }


        return view('tuijianren/add', [
            'yaoqing' => $yaoqing,
        ]);
    }

    /**
     * 编辑被推荐人
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function  edit_beituijianren(Request $request, $id)
    {


        $beituijianren = Beituijianren::find($id);
        if ($request->isMethod('POST')) {
            $tuijianren = Session::get('tuijianren');
            $data = $request->input('Beituijianren');
            $existbeituijianren = DB::table('beituijianren')->where(array('tuijianren_id' => $tuijianren->id, 'phone' => $data['phone']))->first();
            if ($existbeituijianren && $data['phone'] != $beituijianren->phone) {
                return redirect()->back()->withInput()->with('is_exist', '该电话号码已存在!');
            }
            $validator = Tuijianren::beituijianren_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $beituijianren->username = $data['username'];
            $beituijianren->phone = $data['phone'];
            if ($beituijianren->save()) {
                Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',编辑被推荐人(' . $beituijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('tuijianren/tuijianren')->with('success', '修改成功');
            }
        }
        return view('tuijianren/edit', [
            'beituijianren' => $beituijianren,
        ]);
    }

    //添加被推荐人，该推荐人已经添加了该号码，就不能再添加了
    public function  beituijianren_exist(Request $request)
    {
        $phone = $request->get('phone');
        $tuijianren = Session::get('tuijianren');
        $beituijianren = DB::table('beituijianren')->where(array('tuijianren_id' => $tuijianren->id, 'phone' => $phone))->first();
        echo $beituijianren ? 0 : 1;
        exit;
    }

    //推荐人删除被推荐人
    public function del_beituijianren(Request $request, $id)
    {
        $beituijianren = Beituijianren::find($id);
        if ($beituijianren->delete()) {
            $tuijianren = Session::get('tuijianren');
            Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',删除被推荐人(' . $beituijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
            return redirect('tuijianren/tuijianren')->with('success', '删除成功');
        } else {
            return redirect('tuijianren/tuijianren')->with('error', '删除失败');
        }

    }

    //ajax  判断电话号码是否已经注册
    public function phone_exist(Request $request)
    {
        $phone = $request->get('phone');
        $tuijianren = DB::table('tuijianren')->where('phone', $phone)->first();
        echo $tuijianren ? 0 : 1;
        exit;
    }



    /**
     * 被推荐人点击邀请链接，填写自己的信息成为被推荐人
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function addself(Request $request, $id)
    {
        $tuijianren =  DB::table('tuijianren')->where(['id'=>base64_decode($id)])->first();
        if (!$tuijianren) {
            return redirect('tuijianren/register')->with(array('error' => '没有找到对应的推荐人，自己注册成为推荐人吧!'));
        }
        if ($request->isMethod('POST')) {
            $data = $request->input('Beituijianren');

            $existbeituijianren = DB::table('beituijianren')->where(array('tuijianren_id' => $tuijianren->id, 'phone' => $data['phone']))->first();

            if ($existbeituijianren) {
                return redirect()->back()->withInput()->with('is_exist', '该电话号码已存在!');
            }
            $validator = Tuijianren::beituijianren_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['tuijianren_id'] = $tuijianren->id;
            if ($beituijianren = Beituijianren::create($data)) {
                Log::info($tuijianren->username . ',' . $tuijianren->id . ',' . \Route::current()->getActionName() . ',被推荐人自行添加被推荐人(' . $beituijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('index')->with('success', '自荐成功!');
            } else {
                return redirect()->back();
            }
        }
        return view('tuijianren/selfadd');
    }

}