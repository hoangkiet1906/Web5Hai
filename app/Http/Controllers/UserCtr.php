<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserCtr extends Controller
{
    public function index()
    {
        if (Session::has('Suser_name')) {
            return view('User.index', [
                'title' => 'Hi ' . Session::get('Suser_name'),
                'login' => 'myaccount'
            ]);
        } else
            return view('User.index', [
                'title' => 'Hi',
                'login' => 'login'
            ]);
    }
    public function login()
    {
        Session::forget('Suser_name');
        return view('User.login', [
            'title' => 'Hi',
            'login' => 'login'
        ]);
    }
    public function authlogin(Request $req)
    {
        $this->validate($req, [
            'user_name' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt([
            'user_name' => $req->user_name,
            'password' => $req->password
        ])) {
            Session::put('Suser_name', $req->user_name);
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Đăng nhập không thành công');
        }
    }
    public function authres(Request $req)
    {
        // dd($req->all());
        $this->validate($req, [
            'user_name' => 'required',
            'password' => 'required',
            'Cpassword' => 'required'
        ]);

        if ($user = User::where('user_name', '=', $req->user_name)->first()) {
            return redirect()->back()->with('error', 'Tài khoản đã tồn tại');
        } else {
            if ($req->password != $req->Cpassword) {
                return redirect()->back()->with('error', 'Mật khẩu không giống nhau');
            } else {
                DB::table('user')->insert([
                    'user_name' => $req->user_name,
                    'password' => Hash::make($req->password),
                ]);
                return redirect()->back()->with('success', 'Đăng kí thành công');
            }
        }
    }

    public function myaccount()
    {
        if (Session::has('Suser_name')) {
            if ($info = Info::where('user_name', '=', Session::get('Suser_name'))->first()) {
                $row = DB::table('info')->where('user_name', Session::get('Suser_name'))->first();
                return view('User.myaccount', [
                    'title' => 'Hi ' . Session::get('Suser_name'),
                    'login' => 'myaccount',
                    'row' => $row,
                ]);
            }
            else{
                $row=null;
                return view('User.myaccount', [
                    'title' => 'Hi ' . Session::get('Suser_name'),
                    'login' => 'myaccount',
                    'row' => $row,
                ]);
            }
        } else
            return view('User.index', [
                'title' => 'Hi',
                'login' => 'login'
            ]);
    }

    public function upInfo(Request $req)
    {
        if ($info = Info::where('user_name', '=', Session::get('Suser_name'))->first()) {
            DB::update(
                'update info set fullname=?,phone=?,email=?,address=?,deliveryaddress=? where user_name = ?',
                [$req->hoten, $req->sdt, $req->email, $req->dc, $req->dcgiaohang, Session::get('Suser_name')]
            );
            return redirect()->back()->with('chinhsua', 'Successfully edited personal information');
        } else {
            $crow = DB::table('info')->count() + 1;
            DB::table('info')->insert([
                'id' => $crow,
                'fullname' => $req->hoten,
                'phone' => $req->sdt,
                'email' => $req->email,
                'address' => $req->dc,
                'deliveryaddress' => $req->dcgiaohang,
                'user_name' => Session::get('Suser_name'),
            ]);
            return redirect()->back()->with('themmoi', 'Successfully added personal information');
        }
    }
}
