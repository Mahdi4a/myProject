<?php

namespace Modules\Attribute\Http\Attribute;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Attribute\Entities\Attribute;

//use Your Model

/**
 * Class AttributeRepository.
 */
class AttributeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Attribute::class;
    }

    public function getValuesByAttribute($request)
    {
        $attribute = $this->model->query()->with('values')->where('name', $request->id)->firstOrFail();
        return $attribute->values->pluck('value');
    }
}
