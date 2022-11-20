<?php

namespace Modules\Cart\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static cartService put(array $values, $product, $attribute, $value)
 * @method static bool has(string|object $id, $attribute, $value)
 * @method static collection all()
 * @method static mixed get(string|object $id)
 * @method static mixed update(model $product, int $attribute, int $value, int $quantity)
 * @method static string getMessage()
 * @method static mixed count($key, $attribute, $value)
 * @method static bool delete($key, string $attribute = '', string $value = '')
 * @method static cartService instance(string $name = 'default')
 * @method static void flush()
 * @method static int getDiscount()
 */
class Cart extends Facade
{
    /*
     * @return string
     * */
    protected static function getFacadeAccessor(): string
    {
        return "cart";
    }
}
