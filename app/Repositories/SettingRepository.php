<?php

namespace App\Repositories;

use App\Helpers\DataFormat;
use App\Repositories\Criterias\GetByLangCriteria;
use App\Repositories\Traits\RemoveAllTrait;
use App\Repositories\Traits\StaticInstance;
use App\Repositories\Traits\Vars;
use Illuminate\Support\Arr;

class SettingRepository extends AbstractRepository
{
    use StaticInstance,
        Vars,
        RemoveAllTrait;

    /**
     * Set model
     *
     * @return string
     */
    public function model()
    {
        return "App\\Models\\Setting";
    }

    /**
     * Get all setting by lang
     *
     * @param string $lang
     * @return array|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getAll(string $lang = '')
    {
        $lang = getLang($lang);

        if(!$this->hasVar($lang)) {
            $this->pushCriteria(new GetByLangCriteria($lang));
            $list = $this->all();
            $result = [];

            foreach($list as $item) {
                $result[$item->meta_key] = DataFormat::toFormat($item->meta_value, $item->meta_format);
            }

            $this->setVar($lang, $result);
        }

        return $this->getVar($lang);
    }

    /**
     * Get setting value
     *
     * @param string $key
     * @param string $lang
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getValue(string $key, string $lang = '')
    {
        $all = $this->getAll($lang);

        return Arr::get($all, $key, null);
    }

    /**
     * Set setting value
     *
     * @param int $userId
     * @param string $key
     * @param mixed $val
     * @param string $format
     * @param string $lang
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function setValue(int $userId, string $key, $val, string $format = '', string $lang = '')
    {
        $lang = getLang($lang);
        $format = DataFormat::getFormat($format);

        // update saved var
        $all = $this->getAll($lang);
        Arr::set($all, $key, $val);
        $this->setVar($lang, $all);

        return $this->updateOrCreate(
            [
                'meta_key' => $key,
                'lang' => $lang
            ],
            [
                'user_id' => $userId,
                'meta_value' => DataFormat::toString($val, $format),
                'meta_format' => $format
            ]
        );
    }
}
