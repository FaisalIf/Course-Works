<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\User;
use Auth;
use App\Models\MenuItems;
use App\Models\Promotions;
use App\Models\Orders;
use App\Models\OrderItems;


class CartController extends Controller
{
    public function __construct() {
        $this->middleware('auth:customer');
    }

    public function viewCart() {
        $userID = Auth::guard('customer')->user()->customer_id;
        return view('cart.view',['userID' => $userID]);
    }

    public function addToCart(Request $request)
    {
        $userID = Auth::guard('customer')->user()->customer_id;

        // Use 'item_id' instead of 'id' to find the menu item
        $Product = MenuItems::where('item_id', $request->id)->first();

        if (!$Product) {
        return redirect()->back()->with('error', 'Item not found!');
        }

        // Add the item to the cart
        Cart::session($userID)->add([
            'id' => $Product->item_id, // Use 'item_id' as the ID
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $request->quantity,
            'attributes' => [],
            'associatedModel' => $Product,
        ]);

        return redirect()->back()->with('success', 'Item added to cart!');
}

    public function ClearCart() {

        $userID = Auth::guard('customer')->user()->customer_id;
        Cart::session($userID)->clear();
        return redirect()->back();
    }

    public function updateCart(Request $request) {

        $userID = Auth::guard('customer')->user()->customer_id;
        if($request->quantity == 0) {
            Cart::session($userID)->remove($request->id);
            return redirect()->back();
        }

        Cart::session($userID)->update($request->id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
        ));
        return redirect()->back();
    }

    public function addPromoCode(Request $request) {

        $userID = Auth::guard('customer')->user()->customer_id;

        $promo = Promotions::where('name', $request->code)->first();

        if(!$promo) {
            return redirect()->back()->with('error', 'Invalid promo code!');
        }

        $discount = "-".$promo->discount_percentage."%";

        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => $promo->name,
            'type' => 'promo',
            'target' => 'total',
            'value' => $discount,
        ));

        Cart::session($userID)->condition($condition);

        return redirect()->back();
    }

    public function removePromoCode() {
        $userID = Auth::guard('customer')->user()->customer_id;
        Cart::session($userID)->clearCartConditions();
        return redirect()->back();
    }

    public function addDemo() {

        $userID = Auth::guard('customer')->user()->customer_id;
        $Product = MenuItems::inRandomOrder()->first();


        Cart::session($userID)->add([
            'id' => $Product->item_id,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => 1,
            'attributes' => [],
            'associatedModel' => $Product,
        ]);



        return redirect()->back();
    }

    public function checkout() {
        $userID = Auth::guard('customer')->user()->customer_id;
        $items = Cart::session($userID)->getContent();
        $total = Cart::session($userID)->getTotal();
        return view('cart.payment', ['items' => $items, 'total' => $total]);
    }


    public function payment(Request $request){
        $userID = Auth::guard('customer')->user()->customer_id;

        $card_number = $request->cardNumber;
        $expiry = $request->expDate;
        $cvv = $request->ccvNumber;
        $card_name = $request->cardName;

        // Validation
        if($card_number == null || $expiry == null || $cvv == null || $card_name == null) {
            return redirect()->back()->with('error', 'Please fill all fields!');
        } elseif(strlen($card_number) != 19) {
            return redirect()->back()->with('error', 'Invalid card number!');
        } elseif(strlen($cvv) != 3) {
            return redirect()->back()->with('error', 'Invalid CVV number!');
        } elseif(strlen($expiry) != 5) {
            return redirect()->back()->with('error', 'Invalid expiry date!');
        }  elseif(substr($expiry, 0, 2) > 12) {
            return redirect()->back()->with('error', 'Card Expire Date is invalid! Month cannot be greater than 12');
        } elseif(substr($expiry, 3, 2) < date('y')) {
            return redirect()->back()->with('error', 'Card Expire Date is invalid! Year cannot be less than current year');
        }
        // Validation

        $items = Cart::session($userID)->getContent();

        $order = Orders::create([
            'customer_id' => $userID,
            'total_amount' => Cart::session($userID)->getTotal(),
            'payment_status' => 'paid',
        ]);

        $order_id = $order->order_id;
        if($order_id == null) {
            return redirect()->back()->with('error', 'An error occurred while processing your order!');
        }

        foreach($items as $item) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->order_id;
            $orderItem->item_id = $item->id;
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->price;
            $orderItem->save();
        }

        Cart::session($userID)->clear();

        return redirect()->route('order.track');
    }

    public function OrderWithoutPayment() {
        $userID = Auth::guard('customer')->user()->customer_id;

        $items = Cart::session($userID)->getContent();

        $order = Orders::create([
            'customer_id' => $userID,
            'total_amount' => Cart::session($userID)->getTotal(),
            'payment_status' => 'Unpaid',
        ]);

        $order_id = $order->order_id;
        if($order_id == null) {
            return redirect()->back()->with('error', 'An error occurred while processing your order!');
        }

        foreach($items as $item) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->order_id;
            $orderItem->item_id = $item->id;
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->price;
            $orderItem->save();
        }

        Cart::session($userID)->clear();

        return redirect()->route('order.track');
    }


}
