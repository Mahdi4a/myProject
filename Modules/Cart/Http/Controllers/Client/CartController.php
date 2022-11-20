<?php

namespace Modules\Cart\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Cart\Service\Cart;
use Modules\Product\Entities\Product;

class CartController extends Controller
{

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart(Product $product, Request $request): \Illuminate\Http\RedirectResponse
    {
        $value = AttributeValue::query()->find($request->value, ['id', 'price']);
        $cart = Cart::instance($request->cart ?? "default");
        if ($cart->has($product, $request->attribute_id, $value->id)) {
            $cart->update($product, $request->attribute_id, $value->id, $request->add);
        } else {
            $cart->put([
                'quantity' => $request->add,
                'price' => $value->price,
            ], $request->attribute_id, $value->id, $product);
        }
        $message = $cart->getMessage();
        alert('', $message[0], $message[1]);
        return back();
    }

    public function cart()
    {
        $cart = Cart::all();
        $totalPrice = $cart->sum(function ($item) {
            if (!$item['discount_percent']) {
                return $item['price'] * $item['quantity'];
            }
            return ($item['price'] - ($item['price'] * $item['discount_percent'])) * $item['quantity'];
        });
        return view('cart::client.index', compact('cart', 'totalPrice'));
    }

    public function cartDeleteItem($id)
    {
        Cart::delete($id);
        return back();
    }
}
