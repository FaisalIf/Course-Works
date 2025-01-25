<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function viewIncomingOrders()
    {
        $orders = DB::table('orders')
            ->where('status', '!=', 'delivered')
            ->orderBy('order_id', 'desc')
            ->get();

        return view('order.incoming', compact('orders'));
    }

    public function viewOrderStatus()
    {
        $orders = DB::table('orders')->get();
        return view('order.update', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $order_id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Preparing,Ready,Delivered', 
        ]);

        DB::table('orders')
            ->where('order_id', $order_id)
            ->update(['status' => $request->status]);

        return redirect()->route('order.update')->with('success', 'Order status updated successfully.');
    }

    public function viewMenuAvailability()
    {
        $menuItems = DB::table('menuitems')->get();
        return view('items.unavailable', compact('menuItems'));
    }

    public function updateAvailability(Request $request, $item_id)
    {
        $request->validate([
            'is_available' => 'required|boolean',
        ]);

        DB::table('menuitems')
            ->where('item_id', $item_id)
            ->update(['is_available' => $request->is_available]);

        return redirect()->route('items.unavailable')->with('success', 'Item availability updated.');
    }

    public function viewHighlights()
    {
        $menuItems = DB::table('menuitems')
            ->leftJoin('dailyhighlights', 'menuitems.item_id', '=', 'dailyhighlights.item_id')
            ->select('menuitems.*', 'dailyhighlights.highlight_id')
            ->get();

        return view('items.highlight', compact('menuItems'));
    }

    public function toggleHighlight(Request $request, $item_id)
    {
        $isHighlighted = DB::table('dailyhighlights')
            ->where('item_id', $item_id)
            ->exists();

        if ($request->has('highlight') && $request->highlight == 1 && !$isHighlighted) {
            DB::table('dailyhighlights')->insert([
                'item_id' => $item_id,
                'highlight_date' => now(),
            ]);
        } elseif ($request->has('highlight') && $request->highlight == 0 && $isHighlighted) {
            DB::table('dailyhighlights')->where('item_id', $item_id)->delete();
        }

        return redirect()->route('items.highlight')->with('success', 'Highlight updated.');
    }

    public function trackOrder(Request $request)
    {
        $customer_id = Auth::guard('customer')->user()->customer_id;

        $orders = DB::table('orders')
            ->where('customer_id', $customer_id)
            ->orderBy('order_date', 'desc')
            ->get();

        return view('order.track', compact('orders'));
    }
}