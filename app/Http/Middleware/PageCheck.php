<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;

class PageCheck
{
    public function handle(Request $request, Closure $next)
    {
        $isaccess = false;
        $accchk = 0;
        $menus = [];
        if (session()->has("isLoged")) {
            $user_loged = session()->get("userlevel");
        } else {
            $user_loged = "XXXXXXXXXXXX";
        }
        $rmenus = Menu::where('root_menu', '=', '0')
            ->where('stat', '=', '0')
            ->whereRaw('(isall=1 OR FIND_IN_SET(?, user))', [$user_loged])->orderBy('ordr', 'ASC')->get()->toArray();
        // dd($rmenus);
        foreach ($rmenus as $rmenu) {
            $rsl = $rmenu['sl'];
            if ($accchk == 0) {
                $isc = $request->is($rmenu['route_name']);
                if ($isc) {
                    $isaccess = true;
                    $accchk = 1;
                }
            }
            $smenus = Menu::where('root_menu', '=', $rsl)
                ->where('stat', '=', '0')
                ->whereRaw('(isall=1 OR FIND_IN_SET(?, user))', [$user_loged])->orderBy('ordr', 'ASC')->get()->toArray();
            foreach ($smenus as $smenu) {
                if ($accchk == 0) {
                    $isc = $request->is($smenu['route_name']);
                    $iscw = $request->is($smenu['route_name'] . "/*");
                    if ($isc or $iscw) {
                        $isaccess = true;
                        $accchk = 1;
                    }
                }
            }
            $rmenu["sub_menus"] = $smenus;
            $menus[] = $rmenu;
        }
        session()->put("menu", $menus);
        if (
            $isaccess
            or $request->is("change-password")
            or $request->is("menu-assign")
            or $request->is("menu-assigns")
            or $request->is("menu-edit")
            or $request->is("menu-status-update")
            or $request->is("person/status")
            or $request->is("person/edit")
            or $request->is("terms/status")
            or $request->is("terms/edit")
            or $request->is("customer-list")
           
        ) {
            return $next($request);
        } else {
            return redirect("/noaccess");
        }
    }
}
