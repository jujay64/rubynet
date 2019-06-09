<?php

namespace App\Transformers;

use App\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Department $department)
    {
        return [
            'identifier' => (int)$department->id,
            'name' => $department->name,
            'description' => (string)$department->description,
        ];
    }
}
