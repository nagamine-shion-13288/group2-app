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
    'user_phone' => 'required',
    'email' => 'required|email',
    ], [
    'login_id.required' => 'ログインIDを入力してください。',
    'login_id.unique' => 'このログインIDは既に使われています。',
    'password.required' => 'パスワードを入力してください。',
    'password.confirmed' => 'パスワード確認が一致しません。',
    'name.required' => '氏名を入力してください。',
    'address.required' => '住所を入力してください。',
    'user_phone.required' => '電話番号を入力してください。',
    'email.required' => 'メールアドレスを入力してください。',
    'email.email' => '有効なメールアドレスを入力してください。',
    ]);

        Account::create([
            'login_id' => $request->login_id,
            'password_hash' => Hash::make($request->password),
            'name' => $request->name,
            'address' => $request->address,
            'user_phone' => $request->user_phone,
            'email' => $request->email,
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

    // アカウント管理画面を表示
    public function showAccount()
    {
        $userId = session('userId');

        if (!$userId) {
            return redirect('/login')
                ->with('error', 'ログインしてください。');
        }

        $account = Account::find($userId);

        return view('account.account', compact('account'));
    }

    // アカウント更新画面を表示
    public function showAccountUpdateForm()
    {
        $userId = session('userId');

        if (!$userId) {
            return redirect('/login')
                ->with('error', 'ログインしてください。');
        }

        $account = Account::find($userId);

        return view('account.accountupdate', compact('account'));
    }

    // アカウント情報更新処理
    public function accountUpdate(Request $request)
    {
        $userId = session('userId');

        if (!$userId) {
            return redirect('/login')
                ->with('error', 'ログインしてください。');
        }

        $request->validate([
            'name'     => 'required',
            'address'  => 'required',
            'phone'    => 'required',
            'password' => 'required',
        ], [
            'name.required'     => '氏名を入力してください。',
            'address.required'  => '住所を入力してください。',
            'phone.required'    => '電話番号を入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ]);

        $account = Account::find($userId);

        $account->name          = $request->name;
        $account->address       = $request->address;
        $account->user_phone    = $request->phone;
        $account->password_hash = Hash::make($request->password);

        $account->save();

        // セッションの表示名も更新
        session(['userName' => $account->name]);

        return redirect('/account')
            ->with('success', 'アカウント情報を更新しました。');
    }
}