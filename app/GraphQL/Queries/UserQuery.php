<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'search' => [
                'type' => Type::listOf(GraphQL::type('FlexibleFilter')),
                'description' => 'Search query',
                'defaultValue' => []
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return User::query()
            ->with($with)
            ->select($select)
            ->when(isset($args['search']['column']) && $args['search']['column'], function($query) use ($args) {
                $query->where($args['search']['column'], 'like', '%' . $args['search']['value'] . '%' );
            })->get();
    }
}
