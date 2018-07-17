<?php

namespace Library\Http\Request\Type;

use Library\Infrastructure\Type\BaseType;

class InternalTypeType extends BaseType
{
    /**
     * @var array $types
     */
    protected static $types = [
        'paginated_view',
        'paginated_internalized_view',
        'view',
        'creation',
        'update',
    ];
}