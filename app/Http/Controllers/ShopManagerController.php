<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopManagerController extends Controller
{
    public function showAddForm()
    {
        $shops = Shop::all();

        return view('admin.account.shopManagerAdd', compact('shops'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'login_id' => 'required|max:50|unique:shop_managers,login_id',
            'name' => 'required|max:100',
            'password' => 'required|min:8',
        ]);

        ShopManager::create([
            'shop_id' => $request->shop_id,
            'login_id' => $request->login_id,
            'name' => $request->name,
            'password_hash' => Hash::make($request->password),
        ]);

        return redirect('/admin/login')
            ->with('success', '管理者を登録しました');
    }

    public function showLoginForm()
    {
        return view('admin.account.shopManagerLogin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ]);

        $manager = ShopManager::where('login_id', $request->login_id)->first();

        if ($manager && Hash::check($request->password, $manager->password_hash)) {
            session([
                'managerId' => $manager->id,
                'managerName' => $manager->name,
                'shopId' => $manager->shop_id,
            ]);

            return redirect('/');
        }

        return back()
            ->with('error', 'ログインIDまたはパスワードが違います')
            ->withInput();
    }
}