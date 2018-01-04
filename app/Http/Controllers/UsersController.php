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
}
