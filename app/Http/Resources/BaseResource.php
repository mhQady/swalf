<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    // Param. name for scope type in query string
    public const REQUEST_SCOPE_PARAM = 'scope';

    // Scope types
    public const SCOPE_MICRO = 'micro';

    public const SCOPE_MINI = 'mini';

    public const SCOPE_FULL = 'full';

    protected $scope = [];

    protected $modelScope = self::SCOPE_MICRO;

    protected $micro = [];

    protected $mini = [];

    protected $full = [];

    protected $relations = [];

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);

        $this->parseScope(request()->get(self::REQUEST_SCOPE_PARAM));
    }

    public function parseScope($scope)
    {
        foreach (explode(',', $scope) as $modelScope) {
            if (strpos($modelScope, '.') !== false) {
                $modelScope = explode('.', $modelScope);
                $this->scope[lcfirst($modelScope[0])] = $modelScope[1];
            }
        }
    }

    public function setScope($modelScope)
    {
        $this->modelScope = $modelScope;
    }

    public function getScope()
    {
        $modelName = lcfirst(class_basename($this->resource));

        return $this->scope[$modelName] ?? $this->modelScope;
    }

    public function getMicro()
    {
        return $this->micro;
    }

    public function getMini()
    {
        return array_merge($this->getMicro(), $this->mini);
    }

    public function getFull()
    {
        return array_merge($this->getMini(), $this->full);
    }

    public function getResource()
    {
        switch ($this->getScope()) {
            case self::SCOPE_MICRO:
                return $this->getAttributesWithRelations($this->getMicro());
            case self::SCOPE_MINI:
                return $this->getAttributesWithRelations($this->getMini());
            case self::SCOPE_FULL:
                return $this->getAttributesWithRelations($this->getFull());
        }
    }

    public function getAttributesWithRelations($attributes)
    {
        return array_merge($this->relations, $attributes);
    }
}
