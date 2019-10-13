<?php
if(!function_exists('createToken')) {
    /**
     * Create token
     *
     * @param string $name
     * @param bool $is_one_time
     * @param bool $is_unique
     * @param array $args
     * @return string
     */
    function createToken(string $name, bool $is_one_time = true, bool $is_unique = false,  array $args = []): string
    {
        $defaultArgs = [
            'user_id' => (int)auth()->id(),
            'expiration' => false
        ];

        $args = array_merge($defaultArgs, $args);
        $tokenRepository = app(\App\Repositories\TokenRepository::class);
        $params = array(
            'user_id' => $args['user_id'],
            'is_one_time' => $is_one_time ? 1 : 0,
            'is_unique' => $is_unique ? 1 : 0,
            'expiration' => $args['expiration'] !== false ? (int)$args['expiration'] : $args['expiration']
        );

        return $tokenRepository->createToken($name, $params);
    }
}

if(!function_exists('generateToken')) {
    /**
     * Create token string
     *
     * @param int $userId
     * @return string
     */
    function generateToken(int $userId = 0): string
    {
        $timer = microtime(true);
        $domainHash = config('app.domain_hash');
        $md5s = md5($timer) . md5($userId);
        $md5s .= md5($domainHash . $md5s);

        return $md5s;
    }
}
