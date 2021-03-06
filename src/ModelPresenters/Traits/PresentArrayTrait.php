<?php

namespace Tmd\LaravelHelpers\ModelPresenters\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Tmd\LaravelHelpers\Libraries\Pagination\LengthAwarePaginator;
use Tmd\LaravelHelpers\ModelPresenters\Base\ModelPresenterInterface;

trait PresentArrayTrait
{
    /**
     * @param Model[]|\Iterator|Collection $models
     * @param array $args
     *
     * @return array
     */
    public function presentArray($models, ...$args): array
    {
        /** @var ModelPresenterInterface $this */
        $array = [];
        foreach ($models as $model) {
            $presented = $this->present($model, ...$args);
            if (is_array($presented)) {
                $array[] = $presented;
            }
        }

        return $array;
    }

    /**
     * @param \Illuminate\Contracts\Pagination\Paginator|Paginator|LengthAwarePaginator $paginator
     * @param array $args
     *
     * @return array
     */
    public function presentPaginator(\Illuminate\Contracts\Pagination\Paginator $paginator, ...$args)
    {
        $paginator->getCollection()->transform(
            function ($item) use ($args) {
                return $this->present($item, ...$args);
            }
        );
    }
}
