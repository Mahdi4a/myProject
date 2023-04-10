<?php

namespace Modules\Cart\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Modules\Discount\Entities\Discount;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartService
{
    protected \Illuminate\Support\Collection $cart;
    protected string $message;
    protected string $name = 'default';
    protected string $type = 'store';
    protected string $messageType;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \JsonException
     */
    public function __construct()
    {
//        $this->cart = collect(session()->get($this->name) ?? []);
        $this->cart = $this->getCollectCookie();
    }

    /**
     * @param array $values
     * @param $object
     * @return $this
     */
    public function put(array $values, $attribute, $value, $object = null): CartService
    {
        if ($this->checkInventory($object, $attribute, $value, $values['quantity'])) {
            if (!isset($values['id']) && $object instanceof Model) {
                $values = array_merge($values, [
                    'id' => Str::random(10),
                    'subject_id' => $object->id,
                    'subject_type' => get_class($object),
                    'attribute' => $attribute,
                    'attribute_value' => $value,
                    'discount_percent' => 0,
                ]);
                $this->type = 'store';
            }

            $this->message = 'با موفقیت به سبد خرید اضافه شد';
            $this->messageType = 'success';
            $this->cart['items'] = collect($this->cart['items'])->put($values['id'], $values);
//            session()->put($this->name, $this->cart);
            $this->setCookie();
        }
        return $this;

    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key, $attribute = "", $value = ""): bool
    {
        if ($key instanceof Model) {
            return !is_null(
                collect($this->cart['items'])->where('attribute', $attribute)
                    ->where('attribute_value', $value)
                    ->where('subject_id', $key->id)
                    ->firstWhere('subject_type', get_class($key)));
        }

        return !is_null(collect($this->cart['items'])->firstWhere('id', $key));
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key, $attribute = "", $value = "", $relation = false): mixed
    {
        if ($key instanceof Model) {
            $item = (collect($this->cart['items'])->where('attribute', $attribute)
                ->where('attribute_value', $value)
                ->where('subject_id', $key->id)
                ->firstWhere('subject_type', get_class($key)));
        } else {
            $item = (collect($this->cart['items'])->firstWhere('id', $key));
        }
        return $relation ? $this->withRelationShip($item) : $item;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): \Illuminate\Support\Collection
    {
        $cart = $this->cart;
        $cart = collect($this->cart['items'])->map(function ($item) use ($cart) {
            $item = $this->withRelationship($item);
            $item = $this->checkDiscountValidate($item, $cart['discount']);
            return ($item);
        });
        return $cart;
    }

    /**
     * @param $item
     * @return mixed
     */
    protected function withRelationship($item): mixed
    {
        if (isset($item['subject_id']) && isset($item['subject_type']) !== null) {
            $class = $item['subject_type'];
            $subject = (new $class())->find($item['subject_id']);
            $attribute = $subject->attributes->firstWhere('id', $item['attribute']);
            $subject->attribute = $attribute->name;
            $subject->value = $attribute ? $attribute->pivot->value->firstWhere('id', $item['attribute_value'])->value : null;
            $item[lcfirst(class_basename($subject))] = $subject;
        }
        return ($item);
    }

    /**
     * @param $product
     * @param $attribute
     * @param $value
     * @param $quantity
     * @return $this
     */
    public function update($product, $attribute, $value, $quantity): static
    {
        $item = $this->get($product, $attribute, $value);
        if (is_numeric($quantity)) {
            $item['quantity'] = (string)($item['quantity'] + $quantity);
        }

        $this->message = 'تعداد محصول اضافه شد';
        $this->messageType = 'success';
        $this->type = 'update';
        $this->put($item, $attribute, $value, $product);

        return $this;
    }

    /**
     * @param $product
     * @param $attribute
     * @param $value
     * @param $quantity
     * @return bool
     */
    protected function checkInventory($product, $attribute, $value, $quantity): bool
    {
        $inventory = $product->attributes()->where('id', $attribute)->wherePivot('value_id', $value)->first()->pivot->value->inventory;
        $this->message = 'موجودی محصول به اتمام رسیده است';
        $this->messageType = 'error';
        return $quantity <= $inventory;
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return [$this->message, $this->messageType];
    }

    public function count($key, $attribute, $value): mixed
    {
        if (!$this->has($key, $attribute, $value)) return 0;
        return $this->get($key, $attribute, $value)['quantity'];
    }

    /**
     * @param $key
     * @param string $attribute
     * @param string $value
     * @return bool
     */
    public function delete($key, string $attribute = "", string $value = ""): bool
    {
        if ($this->has($key)) {
            $this->cart = collect($this->cart['items'])->filter(function ($item) use ($key, $attribute, $value) {
                if ($key instanceof Model) {
                    return ($item['subject_id'] !== $key->id) && ($item['subject_type'] !== get_class($key))
                        && ($item['attribute'] !== $attribute) && ($item['attribute_value'] !== $value);
                }
                return $key !== $item['id'];
            });
//            session()->put($this->name,$this->cart);
            $this->setCookie();
            return true;
        }
        return false;
    }

    /**
     * @throws \JsonException
     */
    public function instance(string $name = 'default')
    {
//        $this->cart = collect(session()->get($name) ?? []);
        $this->cart = $this->getCollectCookie();
        $this->name = $name;
        return $this;
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->cart = collect([
            'items' => [],
            'discount' => null
        ]);
        $this->setCookie();
    }

    /**
     * @return void
     */
    protected function setCookie(): void
    {
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 7);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCollectCookie(): \Illuminate\Support\Collection
    {

        return collect(json_decode(request()?->Cookie($this->name), true) ?? [
                'items' => [],
                'discount' => null
            ]);
    }

    public function addDiscount($discount)
    {
        $this->cart['discount'] = $discount;
        $this->setCookie();
    }

    protected function checkDiscountValidate($item, $discount)
    {
        $discount = Discount::query()->whereCode($discount)->first();
        if ($discount && $discount->expired_at > now()) {
            if (
                (!$discount->products()->count() && !$discount->categories()->count()) ||
                in_array($item['product']->id, $discount->products()->pluck('id')->toArray(), true) ||
                array_intersect($item['product']->categories->pluck('id')->toArray(), $discount->categories->pluck('id')->toArray())
            ) {
                $item['discount_percent'] = $discount->percent / 100;
            }
        }
        return $item;
    }

    public function getDiscount()
    {
        return Discount::query()->whereCode($this->cart['discount'])->first(['code', 'percent']);
    }

}
