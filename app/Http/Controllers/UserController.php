<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    // 新規登録画面を表示
    public function showAccountAddForm()
    {
    return view('accountAdd');
    }

    // 新規登録処理
    public function accountAdd(Request $request)
    {
        $request->validate([
    'login_id' => 'required|unique:users,login_id',
    'password' => 'required|confirmed',
    'name' => 'required',
    'address' => 'required',
    ], [
    'login_id.required' => 'ログインIDを入力してください。',
    'login_id.unique' => 'このログインIDは既に使われています。',
    'password.required' => 'パスワードを入力してください。',
    'password.confirmed' => 'パスワード確認が一致しません。',
    'name.required' => '氏名を入力してください。',
    'address.required' => '住所を入力してください。',
    ]);

        Account::create([
            'login_id' => $request->login_id,
            'password_hash' => Hash::make($request->password),
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect('/login')
            ->with('success', 'アカウント登録が完了しました。');
    }

    // ログイン画面を表示
    public function showLoginForm()
    {
        return view('login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        $request->validate([
    'id' => 'required',
    'password' => 'required',
    ], [
    'id.required' => 'ログインIDを入力してください。',
    'password.required' => 'パスワードを入力してください。',
    ]);

        $account = Account::where('login_id', $request->id)->first();

        if ($account && Hash::check($request->password, $account->password_hash)) {
    session([
        'userId' => $account->id,
        'userName' => $account->name,
    ]);

            return redirect('/products');
        }

        return back()->withErrors([
            'login' => 'IDまたはパスワードが違います。',
        ])->withInput();
    }

    // ログアウト処理
    public function logout()
    {
        session()->forget([
    'userId',
    'userName'
    ]);

        return redirect('/login');
    }
}