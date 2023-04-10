<?php

namespace Modules\Main\GraphQL\Privacy;

use Rebing\GraphQL\Support\Privacy;

class OwnedRecord extends Privacy
{
    public function validate(array $queryArgs, $queryContext = null): bool
    {
        return $queryArgs['id'] === Auth('api')->user()->id;
    }
}
