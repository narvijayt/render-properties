<?php

namespace App\Http\Controllers\Admin;
use App\NotifyUser;
use App\User;
use Illuminate\Support\Facades\Auth;

class ConsumersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $page_title = 'Render | Admin | Realtors';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
        $users = User::where('user_type', null)
                ->where('username', '!=', 'admin')
                ->orderBy('user_id','desc')
                ->get();

        return view('admin.users.consumers', compact('page_title', 'page_description', 'users'));
    }

    /*
     ** notify user
     */
    public function notifyUsers()
    {
        $page_title = 'Render | Admin | Notify Users';
        $page_description = 'Render Dashboard';

        $this->authorize('view', User::class);
        $users = NotifyUser::all();

        return view('admin.users.notifyUsers', compact('page_title', 'page_description', 'users'));
    }

    /*  
     ** logout user
     */
    public function logout()
    {
         Auth::logout();
         return redirect('cpldashrbcs');
    }

}