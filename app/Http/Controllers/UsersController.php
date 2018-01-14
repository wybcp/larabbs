<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use function compact;
use App\Http\Requests\UserRequest;
use function dd;
use function redirect;
use function view;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>'show']);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /**
     * @param UserRequest $request
     * @param User        $user
     * @param ImageUploadHandler $uploader
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request,ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update',$user);

        $data=$request->all();
        if ($request->avatar){
//            181px，即使要兼容 视网膜屏幕（Retina Screen） 的话，最多 181px * 2 = 362px
            $result=$uploader->save($request->avatar,'aratar',$user->id,362);
            if ($result){
                $data['avatar']=$result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }

}
