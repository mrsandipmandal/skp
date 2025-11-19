<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signup;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;
use App\Models\Customer;
use App\Models\Salon;
use App\Models\Menu;
use App\Models\UserType;

class AdminController extends Controller
{
    public function website(Request $request)
    {

        $resp['error'] = false;
        $data = compact('resp');
        return view("website.index")->with($data);
    }

    public function login(Request $request)
    {
        if (session()->has("isLoged")) {
            return redirect('/dashboard');
        } else {
            $resp['error'] = false;
            $data = compact('resp');
            return view("admin.login")->with($data);
        }
    }

    public function logins(Request $request)
    {
        $request->validate(
            [
                "username" => "required",
                "password" => "required",
            ]
        );

        $username = $request->username;
        $password = $request->password;

        $users = Signup::where('username', '=', $username)->first();

        if ($users) {
            if ($users->actnum == "0") {
                if ($users->password == md5($password)) {
                    $resp['error'] = false;
                    session([
                        'isLoged' => true,
                        'userid' => $users->id,
                        'username' => $users->username,
                        'userlevel' => $users->userlevel,
                        'mobile' => $users->mobile,
                        'email' => $users->email,
                        'name' => $users->name,
                        'designation' => $users->designation,
                        'users' => $users
                    ]);
                } else {
                    $resp['error'] = true;
                    $resp['message'] = "Incorrect username or password";
                }
            } else {
                $resp['error'] = true;
                $resp['message'] = "Account Deactivated";
            }
        } else {
            $resp['error'] = true;
            $resp['message'] = "Not registered";
        }
        if ($resp['error']) {
            $data = compact('resp');
            return view("admin.login")->with($data);
        } else {
            return redirect("/dashboard");
        }
    }

    public function changepass(Request $request)
    {
        $request->validate(
            [
                "oldpass" => "required",
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6'
            ]
        );
        $user = Signup::find(session()->get("userid"));
        if ($user->password == md5($request->oldpass)) {
            $user->password = md5($request->password);
            $user->save();
            $perr = false;
            return redirect("/logout");
        } else {
            $perr = true;
            $page_title = "Dashboard";
            $menus = session()->get("menu");
            $data = compact('page_title', 'menus', 'perr');
            return view('admin.index')->with($data);
        }
    }

    public function dashboard(Request $request)
    {
        if (session()->has("isLoged")) {
            $page_title = "Dashboard";
            $ProjectEntry = [];
            $Bdo = [];
            $Panchayat = [];
            $Beneficiary = [];
            $NatureOfLand = [];
            $menus = session()->get("menu");

            $data = compact('page_title', 'menus', 'ProjectEntry', 'Bdo', 'Panchayat', 'Beneficiary', 'NatureOfLand');
            return view('admin.index')->with($data);
        } else {
            $resp['error'] = false;
            $data = compact('resp');
            return view("admin.login")->with($data);
        }
    }

    public function menu_setup(Request $request)
    {
        $page_title = "Menu Setup";
        $Menu = Menu::orderBy('root_menu', 'ASC')->get()->toArray();
        $usertype = UserType::get();
        $menus = session()->get("menu");
        $data = compact('page_title', 'menus', 'Menu', 'usertype');
        return view('admin.menuSetup')->with($data);
    }

    public function menu_edit(Request $request)
    {
        $page_title = "Menu Setup";
        $Menu = Menu::orderBy('root_menu', 'ASC')->get()->toArray();
        $usertype = UserType::get();
        $MenuEdit = Menu::find($request->sl);
        $menus = session()->get("menu");
        $data = compact('page_title', 'MenuEdit', 'menus', 'Menu', 'usertype');
        return view('admin.menuSetup')->with($data);
    }

    public function menu_setups(Request $request)
    {
        $request->validate([
            'menu_name' => 'required',
            // 'icon' => 'required',
        ]);
        // validate Request Special Characters
        // Helper::validateRequestSpecialCharacters($_REQUEST);
        $sl = $request->sl;
        $menu = Menu::query();
        if ($request['sl'] == 0) {
            $Menu = new Menu;
            Session::flash('Menu_type', 'success');
            Session::flash('Menu_msg', 'Data Entry Successfully.');
        } else {
            $Menu = Menu::find($request->sl);
            $menu->where('sl', '!=', $sl);
            Session::flash('Menu_type', 'success');
            Session::flash('Menu_msg', 'Data Update Successfully.');
        }

        $menu->where('route_name', $request->route_name)->where('menu_name', $request->menu_name);
        $cat = $menu->get()->toArray();
        $cnt = count($cat);
        if ($cnt == 0) {
            $Menu->menu_name = $request->menu_name;
            $Menu->root_menu = $request->root_menu;
            $Menu->route_name = $request->route_name;
            $Menu->icon = $request->icon;
            $Menu->ordr = $request->ordr;
            $Menu->is_edit = $request->is_edit ? 1 : 0;
            $Menu->is_delete = $request->is_delete ? 1 : 0;
            $Menu->is_active = $request->is_active ? 1 : 0;
            $Menu->is_export = $request->is_export ? 1 : 0;
            $Menu->eby = session()->get("username");
            $Menu->save();
        } else {
            Session::flash('Menu_type', 'warning');
            Session::flash('Menu_msg', 'Data Already Exists.');
        }
        return redirect('menu-setup');
    }

    public function menu_assign(Request $request)
    {
        $UserType = UserType::get()->toArray();
        return response()->json($UserType);
    }

    public function menu_assigns(Request $request)
    {

        if (isset($request->sl)) {
            $Menu = Menu::find($request->sl);
            $Menu->user = $request->user ? implode(',', $request->user) : null;
            $Menu->isall = $request->isall ? 1 : 0;
            $Menu->save();
            Session::flash('Menu_type', 'success');
            Session::flash('Menu_msg', 'Assign Successfully.');
            return redirect('menu-setup');
        } else {
            Session::flash('Menu_type', 'warning');
            Session::flash('Menu_msg', 'Something Want Wrong! Reload The Page.');
        }
    }

    public function menu_status_update(Request $request)
    {
        if (isset($request->sl) && isset($request->stat)) {
            $Menu = Menu::find($request->sl);
            $Menu->stat = $request->stat;
            $Menu->save();
            $msg = '';
            if ($request->stat == '1') {
                $msg = 'Inactivated Successfully.';
            } else {
                $msg = 'Activated Successfully.';
            }

            Session::flash('Menu_type', 'success');
            Session::flash('Menu_msg', $msg);
            return redirect('menu-setup');
        } else {
            Session::flash('Menu_type', 'warning');
            Session::flash('Menu_msg', 'Something Want Wrong! Reload The Page.');
        }
    }
}
