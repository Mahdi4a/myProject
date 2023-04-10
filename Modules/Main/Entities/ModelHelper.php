<?php

namespace Modules\Main\Entities;

trait ModelHelper
{

    public function markStatusAsActive()
    {
        return $this->forceFill([
            'status' => 1,
        ])->save();
    }

}
