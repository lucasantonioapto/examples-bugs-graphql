<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FlexibleFilterType extends GraphQLType
{
    protected $attributes = [
        'name' => 'FlexibleFilter',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'column' => [
                'type' => Type::string(),
                'description' => 'The column of the filter'
            ],
            'value' => [
                'type' => Type::string(),
                'description' => 'The value of the filter'
            ],
        ];
    }
}
