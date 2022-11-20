<?php

namespace Modules\Product\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cart\Service\Cart;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $productRepository)
    {
        $this->middleware('ajax')->only('getValue', 'getValueDetails');
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->getProductsForClient($request);
        return view('product::client.products', compact('products'));
    }

    public function single(Product $product)
    {
        $product = $this->productRepository->getSingleProduct($product);
        return view('product::client.single', compact('product'));
    }

    public function getValue(Request $request)
    {
        $values = $this->productRepository->getAttributeValue($request);
        $price_with_discount = $values->first()->price - ($values->first()->discount * $values->first()->price) / 100;
        return response()->json([
            'view' => view('product::client.value', compact('values'))->render(),
            'id' => $values->first()->id,
            'attribute_id' => $values->first()->attribute_id,
            'price_with_discount' => $price_with_discount,
            'price' => $values->first()->price,
            'count' => '',
        ]);
    }

    public function getValueDetails(Request $request)
    {
        return $this->productRepository->getValueDetail($request);
    }
}
