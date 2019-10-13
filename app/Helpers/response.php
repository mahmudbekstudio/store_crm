<?php
if(!function_exists('responseData')) {
    /**
     * Wrap response
     *
     * @param bool $result
     * @param array $data
     * @return array
     */
    function responseData(bool $result, array $data = []): array
    {
        return array_merge(['result' => $result], $data);
    }
}

if(!function_exists('responseMessage')) {
    /**
     * Wrap response with message
     *
     * @param bool $result
     * @param $message
     * @param array $data
     * @return array
     */
    function responseMessage(bool $result, $message, array $data = []): array
    {
        return responseData($result, array_merge(['message' => $message], $data));
    }
}
