<?php

namespace App\Repositories;

use App\Repositories\Traits\RemoveAllTrait;
use App\Repositories\Traits\StaticInstance;

class TokenRepository extends AbstractRepository
{
    use
        RemoveAllTrait,
        StaticInstance;

    /**
     * Set model
     *
     * @return string
     */
    public function model()
    {
        return "App\\Models\\Token";
    }

    /**
     * Create new token
     *
     * @param string $name
     * @param array $params
     * @return string
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createToken(string $name, array $params = []): string
    {
        $defaults = [
            'user_id' => 0,
            'is_one_time' => 0,
            'action' => '',
            'is_unique' => 0,
            'expiration' => false
        ];

        $params = array_merge($defaults, $params);

        if($params['is_unique']) {
            //website_id, user_id, is_one_time, is_unique, $name
            $this->deleteWhere([
                'user_id'       => $params['user_id'],
                'is_one_time'   => $params['is_one_time'],
                'name'          => $name,
                'is_unique'     => $params['is_unique']
            ]);
        }

        $token = generateToken($params['user_id']);
        $nowtime = utcTime();

        if($params['expiration'] === false) {
            if($params['is_one_time']) {
                $params['expiration'] = 7 * 24 * 60;
            } else {
                $params['expiration'] = 365 * 24 * 60;
            }
        }

        $this->create([
                'user_id'       => $params['user_id'],
                'token'         => $token,
                'is_one_time'   => $params['is_one_time'],
                'name'          => $name,
                'action'        => $params['action'],
                'is_unique'     => $params['is_unique'],
                'expiration'    => $nowtime + $params['expiration'] * 60
            ]);

        return $token;
    }

    /**
     * Token get by params
     *
     * @param array $params
     * @param bool $checkExpiration
     * @return mixed
     */
    public function getBy(array $params = [], bool $checkExpiration = false)
    {
        $where = [];
        $defaultParams = [
            'user_id' => (int)auth()->id(),
            'token' => false,
            'name' => false,
            'action' => false,
            'is_unique' => false
        ];

        foreach($defaultParams as $key => $val) {
            if(!isset($params[$key]) && $val !== false) {
                $params[$key] = $defaultParams[$key];
            }
        }

        foreach($params as $key => $val) {
            if($val !== false) {
                $where[] = [$key, '=', $val];
            }
        }

        if($checkExpiration) {
            $where[] = ['expiration', '>', time()];
        }

        return $this->findWhere($where)->first();
    }

    /**
     * Remove selected token by name
     *
     * @param string $token
     * @param string $name
     * @return int
     */
    public function removeToken(string $token, string $name): int {
        $token = addslashes(trim($token));
        $name = addslashes(trim($name));

        return $this->deleteWhere([
            'token' => $token,
            'name'  =>$name
        ]);
    }
}