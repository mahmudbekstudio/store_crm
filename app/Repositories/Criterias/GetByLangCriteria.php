<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetByLangCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    private $lang;

    /**
     * GetByLangCriteria constructor.
     *
     * @param string $lang
     */
    public function __construct(string $lang)
    {
        $this->lang = $lang;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereIn('lang', [app()->getLocale(), '']);
    }
}
