<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use function back;
use function compact;
use Hash;
use Illuminate\Http\Request;
use Mail;
use function redirect;
use function session;
use function view;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'login', 'checkLogin','index','confirmEmail']
        ]);

        $this->middleware('guest', [
            'only' => ['login', 'create','confirmEmail']
        ]);
    }

    public function index()
    {
        $users=User::paginate(10);
        return view('users.index',compact('users'));
    }


    /**创建用户，注册页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name'     => 'required|min:3|max:30',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        session()->flash('success', '资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $this->sendActiveEmail($user);
//        Auth::login($user);
//
//        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
//
//        return redirect()->route('users.show', compact('user'));
        session()->flash('success', '验证邮箱已发送到你的激活邮箱');

        return redirect()->route('home');
    }

    protected function sendActiveEmail($user){

        $view='emails.confirm';
        $data=compact('user');
        $from='wangyb65@gmail.com';
        $name='bobo';
        $to=$user->email;
        $subject='激活';
        Mail::send($view,$data,function ($message) use ($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });

    }

    /**
     * 显示登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * 登录验证
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkLogin(Request $request)
    {
        $credentials = $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->activated){
                session()->flash('success', "欢迎回来，" . Auth::user()->name . "！");
                return redirect()->intended(route('users.show', [Auth::user()]));
            }else{
                Auth::logout();
                session()->flash('warning', '您的邮箱未激活！');
                return redirect()->route('home');
            }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return back();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', '你已成功退出！');
        return redirect()->route('login');
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除'.$user->name);
        return back();
    }

    public function confirmEmail($token)
    {
        $user=User::where('activation_token',$token)->firstOrFail();
        $user->activated=true;
        $user->activation_token=null;
        $user->save();

        Auth::login($user);
        session()->flash('success','激活成功！');
        return redirect()->route('users.show',compact('user'));
        
    }
}
