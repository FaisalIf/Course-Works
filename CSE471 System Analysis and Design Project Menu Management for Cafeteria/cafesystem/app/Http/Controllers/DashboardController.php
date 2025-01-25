<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function adminDashboard()
    {
        return view('dashboards.admin');
    }

    public function userDashboard()
    {
    
        $highlightedItems = DB::table('menuitems')
            ->join('dailyhighlights', 'menuitems.item_id', '=', 'dailyhighlights.item_id')
            ->select('menuitems.*')
            ->get();

        return view('dashboards.user', [
            'highlightedItems' => $highlightedItems
        ]);
    }
}