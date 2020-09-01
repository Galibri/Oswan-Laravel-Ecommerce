<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $productId  = $request->id;
        $productQty = $request->qty;

        if (auth()->check()) {
            $user_cart = Cart::where('user_id', auth()->user()->id)->latest()->first();
            if ($user_cart) {
                $cart_items             = json_decode($user_cart->cart_items, true);
                $cart_items[$productId] = ['qty' => $productQty];
                $user_cart->cart_items  = json_encode($cart_items);
            } else {
                $user_cart             = new Cart();
                $user_cart->user_id    = auth()->user()->id;
                $user_cart->cart_items = json_encode([$productId => ['qty' => $productQty]]);
            }
            $user_cart->save();
        } else {
            $request->session()->put('cart.' . $productId . '.qty', $productQty);
        }
    }

    public function get_cart()
    {
        if (auth()->check()) {
            $user_cart = Cart::where('user_id', auth()->user()->id)->latest()->first();
            if ($user_cart) {
                return json_decode($user_cart->cart_items, true);
            }
            return array();
        }
        if (session()->has('cart')) {
            return session('cart');
        }
        return array();
    }

    public function cart_action_after_login()
    {
        if (auth()->check()) {
            if (session()->has('cart')) {
                $user_cart = Cart::where('user_id', auth()->user()->id)->latest()->first();
                if ($user_cart) {
                    $cart_items            = json_decode($user_cart->cart_items, true);
                    $new_items             = session('cart') + $cart_items;
                    $user_cart->cart_items = json_encode($new_items);
                } else {
                    $user_cart             = new Cart();
                    $user_cart->user_id    = auth()->user()->id;
                    $user_cart->cart_items = json_encode(session('cart'));
                }
                if ($user_cart->save()) {
                    session()->forget('cart');
                }
            }
        }
    }

    public function update_cart(Request $request)
    {

    }

    public function remove_from_cart(Request $request)
    {

    }

}