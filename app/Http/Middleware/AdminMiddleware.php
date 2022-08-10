<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Support\Facades\Cookie;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Cookie::get('Admin') != null){
            $userName = decrypt(Cookie::get('Admin'));
            if($userName){
                $Admin = Admin::where('user_name', $userName)->first();
                if($Admin){
                    $request->session()->put('Admin',$Admin);
                }
            }
        }
        if($request->session()->has('Admin')){
            global $Admin;
            $Admin = Admin::find($request->session()->get('Admin')->id);

        }else{
            return redirect('/admin/login')->with('msg',trans('messages.no_user_found'));
        }

        # Segment
        view()->share('section', $request->segment(2));
        view()->share('url',str_replace(url('/'),'',url()->current()));


        # Admin
        view()->share('Admin',$Admin);


        return $next($request);
    }
}
