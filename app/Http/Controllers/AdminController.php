<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/20
 * Time: 9:33
 */
namespace App\Http\Controllers;


use App\Admin;
use App\Beituijianren;
use App\Huodong;
use App\Shop;
use App\Szm;
use App\Tuijianren;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //项目第一次访问设置管理员（管理员名称一定要是admin）,注册后该方法主要用于登录
    public function index(Request $request)
    {
        //管理员登录
        if ($request->isMethod('POST')) {
            $data = $request->input();
            $admin = DB::table('admin')->where(array('phone' => $data['phone'], 'password' => md5($data['password'])))->first();
            if ($admin) {
                session(array('admin' => $admin));
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',登录操作,时间：' . date('Y-m-d H:i:s', time()));
                return redirect('home');
            } else {
                return view('admin/login');
            }
        }
        //看数据库是否有一个管理者，如果有让他登录，没有让他注册一个，注册一个后就以后就直接跑到登录页面，不再注册，，此项目先只要一个管理员
        $admin = DB::table('admin')->first();
        if ($admin) {
            return view('admin/login');
        }
        return view('admin/setting');
    }

    public function validate_captcha()
    {
        $userInput = \Request::get('captcha');
        if (Session::get('milkcaptcha') != $userInput) {
            return true;
        }
        return false;
    }

    //登出
    public function admin_exit(Request $request)
    {
        $admin = $request->session()->get('admin');
        Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',退出登录,时间：' . date('Y-m-d H:i:s', time()));
        $request->session()->forget('admin');
        return redirect('tuiguangadmin');
    }


    //登录成功后，管理进入管理界面
    public function home(Request $request)
    {
        //统计
        $data = Szm::total();
        //商家数量
        $data['shopno'] = DB::table('shop')->where(array('is_delete' => 0))->count();
        //推荐人数量
        $data ['tuijianrenno'] = DB::table('tuijianren')->where(array('is_delete' => 0))->count();
        //被推荐人数量
        $data['beituijianrenno'] = DB::table('beituijianren')->count();
        return view('admin/home', [
            'data' => $data,
        ]);
    }

    /**
     * 登记功能，，登记成功后生产数字码
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function dj(Request $request)
    {

        $shops = DB::table('shop')->get();
        if ($request->isMethod('POST')) {
            $validator = Admin::szm_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request->input('Dj');
            $data['order_time'] = strtotime($data['order_time']);
            $tuijianren = Tuijianren::find($data['tuijianren']);
            $tuijianren_phone = $tuijianren->phone;
            $shop = Shop::find($data['shop']);
            $doorno = $shop->doorno;
            $str = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
            shuffle($str);
            $str = implode('', array_slice($str, 0, 4));
            $data['szm'] = $doorno . substr($tuijianren_phone, 7) . $str;
            $data['commission'] = round($data['money'] * 0.05, 2);
            if ($szm = Szm::create($data)) {
                $admin = $request->session()->get('admin');
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',登记消费(' . $szm->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('szm/list')->with('success', '数字码生成成功：' . $data['szm']);
            } else {
                return redirect()->back()->withInput();
            }

        }
        return view('admin/dj', [
            'shops' => $shops,
        ]);
    }

    /**
     * 数字码列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function szm_list(Request $request, $id = '', $who = '')
    {
        $where = [];
        $view='szm_list';
        if ($id && $who) {
            if($who=='tuijianren'){
                $view='tjr_szm';
            }else{
                $view='sj_szm';
            }
            $where = array($who => $id);
        }
        $szms = DB::table('szm')->where($where)->paginate(20);
        //统计
        $data = Szm::total();
        $curr = $this->curr_total($szms);
        return view("admin/$view", [
            'szms' => $szms,
            'data' => $data,
            'curr' => $curr,
        ]);

    }


    /**
     * 本页统计
     * @param $szms
     * @return array
     */
    protected function curr_total($szms)
    {
        $curr_money = $curr_commission0 = $curr_commission1 = 0;
        $curr = [];
        $ids = '';
        foreach ($szms as $s) {
            $curr_money += $s->money;
            if ($s->is_over == 0) {
                $curr_commission0 += $s->commission;
                $ids .= '|' . $s->id;
            } else {
                $curr_commission1 += $s->commission;
            }
        }
        $curr['curr_money'] = $curr_money;
        $curr['curr_commission0'] = $curr_commission0;
        $curr['curr_commission1'] = $curr_commission1;
        $curr['ids'] = $ids;
        return $curr;
    }


    /**
     * 填写被推荐人后，，找出推荐人，用于被推荐人选择推荐人
     * @param Request $request
     */
    public function  search_tuijianren(Request $request)
    {
        $phone = $request->get('phone');
        $tuijianrens = DB::table('beituijianren')->join('tuijianren', 'tuijianren.id', '=', 'beituijianren.tuijianren_id')
            ->select('tuijianren.id', 'tuijianren.username', 'tuijianren.phone')->where(array('beituijianren.phone' => $phone))->get();
        echo json_encode($tuijianrens);
        exit;
    }

    /**
     * 推荐人列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function tuijianren(Request $request)
    {
        $tuijianrens = DB::table('tuijianren')->where(array('is_delete' => 0))->select('id', 'username', 'phone', 'created_at', 'updated_at')->paginate(20);
        $curr_count = $this->curr_count($tuijianrens, 'tuijianren');
        return view('admin/tuijianren', [
            'tuijianrens' => $tuijianrens,
            'curr_count' => $curr_count,
        ]);
    }

    protected function curr_count($counts, $who)
    {
        $curr_count = 0;
        foreach ($counts as &$c) {
            $count = DB::table('szm')->where(array($who => $c->id))->count();
            $curr_count += $count;
            $c->count = $count;
        }
        return $curr_count;
    }

    /**
     * 商家列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function  shop_list(Request $request)
    {
        $shops = DB::table('shop')->where(array('is_delete' => 0))->paginate(20);
        $curr_count = $this->curr_count($shops, 'shop');
        return view('admin/shop_list', [
                'shops' => $shops,
                'curr_count' => $curr_count,
            ]
        );
    }


    /**
     * 添加商家
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function shop_add(Request $request)
    {
        $data = $request->input('Shop');
        $shop = DB::table('shop')->where(array('doorno' => $data['doorno']))->first();
        if ($shop) {
            return redirect()->back()->withInput()->with('is_exist', '该门牌号的商家已添加!');
        }
        if ($request->isMethod('POST')) {
            $validator = Admin::shop_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if ($shop = Shop::create($data)) {
                $admin = $request->session()->get('admin');
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',添加商家(' . $shop->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('shop/list')->with('success', '添加成功!');
            } else {
                return redirect()->back();
            }
        }
        return view('admin/shop_add');
    }


    //设置管理员
    public function create(Request $request)
    {

        if ($this->validate_captcha()) {
            return redirect()->back()->withInput()->with('captcha_error', '验证码错误!');
        }
        $data = $request->input('Admin');

        $admin = DB::table('admin')->where(array('phone' => $data['phone']))->first();
        if ($admin) {
            return redirect()->back()->withInput()->with('is_exist', '该电话号码已存在!');
        }
        $admin = DB::table('admin')->where(array('username' => $data['username']))->first();
        if ($admin) {
            return redirect()->back()->withInput()->with('username_is_exist', '该账号已存在!');
        }
        $validator = Admin::admin_validatior($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['password'] = md5($data['password']);
        if (Admin::create($data)) {
            return redirect('tuiguangadmin')->with('success', '添加成功!');
        } else {
            return redirect()->back();
        }

    }

    //添加管理员，数据库有了该号码或者已经注册了的用户名，就不能再添加了
    public function phone_exist(Request $request)
    {
        $para = $request->get('para');
        $iswhat = $request->get('iswhat');
        $tuijianren = DB::table('admin')->where($iswhat, $para)->first();
        echo $tuijianren ? 0 : 1;
        exit;
    }

    /**
     * 商家门牌号是否已经注册
     * @param Request $request
     */
    public function doorno_exist(Request $request)
    {
        $doorno = $request->get('doorno');
        $shop = DB::table('shop')->where(array('doorno' => $doorno))->first();
        echo $shop ? 0 : 1;
        exit;
    }


    /**
     * 删除推荐人
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function admin_tjr_delete(Request $request, $id)
    {
        $tuijianren = Tuijianren::find($id);
        $tuijianren->is_delete = 1;
        if ($tuijianren->save()) {
            $admin = $request->session()->get('admin');
            Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',删除推荐人(' . $tuijianren->id . '),时间：' . date('Y-m-d H:i:s', time()));
        }
        return redirect()->back();

    }

    /**
     * 删除商家
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function admin_sj_delete(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->is_delete = 1;
        if ($shop->save()) {
            $admin = $request->session()->get('admin');
            Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',删除商家(' . $shop->id . '),时间：' . date('Y-m-d H:i:s', time()));
        }
        return redirect()->back();
    }

    /**
     * 编辑商家
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function admin_sj_edit(Request $request, $id)
    {
        $shop = Shop::find($id);
        if ($request->isMethod('POST')) {
            $validator = Admin::shop_validator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request->input('Shop');
            $shop->shopname = $data['shopname'];
            $shop->doorno = $data['doorno'];
            $shop->username = $data['username'];
            $shop->phone = $data['phone'];
            if ($shop->save()) {
                $admin = $request->session()->get('admin');
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',编辑商家(' . $shop->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('shop/list')->with('success', '更新成功');
            } else {
                return redirect()->back()->withInput();
            }

        }
        return view('admin/admin_sj_edit', [
            'shop' => $shop,
        ]);
    }


    /**
     * 结算功能
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function js(Request $request, $id)
    {
        $admin = $request->session()->get('admin');
        $szm = Szm::find($id);
        $szm->is_over = 1;
        if ($szm->save()) {
            Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',推荐人结算佣金成功(' . $szm->id . '),时间：' . date('Y-m-d H:i:s', time()));
            return redirect()->back()->with('success', '结算成功');
        } else {
            Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',推荐人结算佣金失败(' . $szm->id . '),时间：' . date('Y-m-d H:i:s', time()));
            return redirect()->back()->with('error', '结算失败');
        }
    }

    /**
     * 本页结算
     * @param Request $request
     * @param $ids
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function many_js(Request $request, $ids)
    {
        $admin = $request->session()->get('admin');
        $ids = explode('|', trim($ids, '|'));
        $not_over_ids = $over_ids = '';
        $not_over_commission = $over_commission = 0;
        foreach ($ids as $id) {
            $szm = Szm::find($id);
            $szm->is_over = 1;
            if ($szm->save()) {
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',推荐人结算佣金成功(' . $szm->id . '),时间：' . date('Y-m-d H:i:s', time()));
                $over_ids .= ',' . $szm->id;
                $over_commission += $szm->commission;
            } else {
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',推荐人结算佣金失败(' . $szm->id . '),时间：' . date('Y-m-d H:i:s', time()));
                $not_over_ids .= ',' . $szm->id;
                $not_over_commission += $szm->commission;
            }
        }
        $over_ids = trim($over_ids, ',');
        $not_over_ids = trim($not_over_ids, ',');
        return redirect()->back()
            ->with('success', '结算成功的IDS:' . $over_ids . '&nbsp;&nbsp;&nbsp;&nbsp;未结算成功的IDS:' . $not_over_ids . '&nbsp;&nbsp;&nbsp;&nbsp;结算成功的金额：' . $over_commission . '&nbsp;&nbsp;&nbsp;&nbsp;未结算成功的金额：' . $not_over_commission);
    }

    /**
     *
     * 被推荐人列表
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function  tjr_btjr(Request $request, $id)
    {

        $beituijianrens = DB::table('beituijianren')->where(array('tuijianren_id' => $id))->paginate(20);
        $Szm = DB::table('szm');
        foreach ($beituijianrens as &$b) {
            $money = $Szm->where(array('tuijianren' => $id, 'phone' => $b->phone))->sum('money');
            $commission = $Szm->where(array('tuijianren' => $id, 'phone' => $b->phone))->sum('commission');
            $count = $Szm->where(array('tuijianren' => $id, 'phone' => $b->phone))->count();
            $b->money = $money;
            $b->commission = $commission;
            $b->count = $count;
        }
        return view('admin/tjr_btjr', [
            'beituijianrens' => $beituijianrens,
        ]);
    }

    /**
     * 添加活动
     * @param Request $request
     */
    public function huodong_add(Request $request)
    {

        if ($request->isMethod('POST')) {
            $validater = Admin::huodong_validator($request);
            if ($validater->fails()) {
                return redirect()->back()->withErrors($validater)->withInput();
            }
            $data = $request->input('Huo');
            if (strtotime($data['open_time']) >= strtotime($data['close_time'])) {
                return redirect()->back()->withInput()->with(['error' => '活动时间设置不合法！']);
            }
            $data['open_time'] = strtotime($data['open_time']);
            $data['close_time'] = strtotime($data['close_time']);
            $data['intro'] = trim($data['intro']);
            $data['info'] = trim($data['info']);
            if ($huodong = Huodong::create($data)) {
                $admin=session('admin');
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',添加活动成功(' . $huodong->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('huodong')->with(['success' => '添加成功']);
            } else {
                return redirect()->back()->with(['error' => '添加失败'])->withInput();
            }
        }
        return view('admin/huodong_add');
    }

    /**
     * 活动列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function huodong(Request $request)
    {
        $huodongs = DB::table('huodong')->where(['is_delete' => 0])->paginate(20);
        return view('admin/huodong', [
            'huodongs' => $huodongs,
        ]);
    }

    /**
     * 查看活动详情
     * @param Request $request
     * @param $id
     */
    public function huodong_detail(Request $request, $id)
    {
        $huodong = Huodong::find($id);
        return view('admin/huodong_detail', [
            'huodong' => $huodong,
        ]);
    }

    /**
     * 活动删除
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function huodong_delete(Request $request, $id)
    {
        $huodong = Huodong::find($id);
        $huodong->is_delete = 1;
        if($huodong->save()){
            $admin=session('admin');
            Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',删除活动成功(' . $huodong->id . '),时间：' . date('Y-m-d H:i:s', time()));
            return redirect()->back()->with(['success' => '删除成功']);
        }else{
            return redirect()->back()->with(['error' => '删除失败']);
        }

    }

    /**
     * 编辑活动
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function huodong_eidt(Request $request, $id)
    {
        $huodong = Huodong::find($id);
        if ($request->isMethod('POST')) {
            $validater = Admin::huodong_validator($request);
            if ($validater->fails()) {
                return redirect()->back()->withErrors($validater)->withInput();
            }
            $data = $request->input('Huo');
            if (strtotime($data['open_time']) >= strtotime($data['close_time'])) {
                return redirect()->back()->withInput()->with(['error' => '活动时间设置不合法！']);
            }
            $huodong->name = $data['name'];
            $huodong->username = $data['username'];
            $huodong->phone = $data['phone'];
            $huodong->open_time = strtotime($data['open_time']);
            $huodong->close_time = strtotime($data['close_time']);
            $huodong->intro = $data['intro'];
            $huodong->info = $data['info'];
            if ($huodong->save()) {
                $admin=session('admin');
                Log::info($admin->username . ',' . $admin->id . ',' . \Route::current()->getActionName() . ',编辑活动成功(' . $huodong->id . '),时间：' . date('Y-m-d H:i:s', time()));
                return redirect('huodong')->with(['success' => '编辑成功']);
            } else {
                return redirect()->back()->withInput()->with(['error' => '编辑失败']);
            }
        }
        return view('admin/huodong_edit', [
            'huodong' => $huodong,
        ]);
    }


}