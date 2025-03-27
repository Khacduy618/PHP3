<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $page_title = "NEWS - Đăng nhập";
        return view("client.auth.login", compact("page_title"));
    }

    public function showRegisterForm()
    {
        $page_title = "NEWS - Đăng ký";
        return view("client.auth.register", compact("page_title"));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        // Kiểm tra thông tin đăng nhập
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Đăng nhập thành công
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        } else {
            // Đăng nhập thất bại
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không chính xác.');
        }
    }

    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        try {
            // Tạo người dùng mới
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
                'remember_token' => \Str::random(10),
            ]);

            // Đăng nhập người dùng sau khi đăng ký
            Auth::login($user);

            // Chuyển hướng đến trang chủ hoặc trang khác
            return redirect()->route('home')->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình đăng ký. Vui lòng thử lại.');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
