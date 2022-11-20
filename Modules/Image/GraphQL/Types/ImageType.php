<?php

declare(strict_types=1);

namespace Modules\Image\GraphQL\Types;

use Modules\Image\Entities\Image;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ImageType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Image',
        'description' => 'image type',
        'model' => Image::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'description' => "the id of image",
                'type' => Type::string(),
            ],
            "address" => [
                'description' => "the address of image",
                'type' => Type::string(),
            ],
            "imageAble_type" => [
                'description' => "the imageAble_type of image",
                'type' => Type::string(),
            ],
            "imageAble_id" => [
                'description' => "the imageAble_id of image",
                'type' => Type::string(),
            ],
        ];
    }
}
