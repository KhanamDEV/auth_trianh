<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {


        $loginSuccess = Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        $user = DB::table('users')->where('email', $request->get('email'))->first();

        if (!$user->status) {dd("TAI KHOAN CUA BAN DA BI KHOA");}

        if (!empty($user)){

            //Case nguoi dung nhap sai mat khau
            if (!$loginSuccess){
                // add history login
                DB::table('authentication_history_events')
                    ->insert([
                        'user_id' => $user->id,
                        'ip_address' => $request->ip(),
                        'event' => LOGIN_FAILED,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                // dem so lan login sai
                // neu login sai 3 lan thi khoa tai khoan
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'number_login_failed' => $user->number_login_failed + 1,
                        'status' => $user->number_login_failed + 1 != 3,
                        'updated_at' => now()
                    ]);

                if ($user->number_login_failed + 1 == 3){
                    dd("TAI KHOAN DA BI KHOA" );

                } else {
                    dd("Ban con ". 3 - $user->number_login_failed - 1 . " LAN LOGIN" );

                }
            } else { // case nguoi dung nhap dung mat khau
                // kiem tra ip hienj tai va ip dang nhap lan cuoi cung
                $lastLogin = DB::table('authentication_history_events')
                    ->where('user_id', $user->id)
                    ->where('event', LOGIN)
                    ->orderBy('id', 'DESC')
                    ->first();

                if (empty($lastLogin) || $lastLogin->ip_address != $request->ip()){
                    // Neu nguoi dung chua dang nhap bat ki 1 lan nao
                    // Neu nguoi dung da dang nhap o noi khac va ip khac ip hien tai
                    $code = Str::random(6);
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'authentication_code' => $code,
                            'updated_at' => now()
                        ]);
                    // GUI EMAIL CHO NGUOI DUNG
                    dd("CODE DA DUOC GUI VE EMAIL" ." ". $code);

                } else {
                    DB::table('authentication_history_events')
                        ->insert([
                            'user_id' => $user->id,
                            'event' => LOGIN,
                            'ip_address' => $request->ip(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    dd("LOGIN THANH CONG");
                }
            }



        } else{
            dd("Thong bao cho nguo dung");
        }


    }
}
