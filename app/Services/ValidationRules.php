<?php

namespace App\Services;

class ValidationRules
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [// Model's field rules list
        'user' => [
            'email'           => [
                'required' => true,
                'string'   => true,
                'email'    => true,
                'max'      => 255,
                'unique'   => 'users,email',
            ],
            'password'        => [
                'required'  => true,
                'string'    => true,
                'min'       => 8,
                'confirmed' => true,
            ],
            'first_name'      => [
                'required' => true,
                'string'   => true,
                'max'      => 40,
            ],
            'last_name'       => [
                'required' => true,
                'string'   => true,
                'max'      => 40,
            ],
            'phone'           => [
                'required' => true,
                'string'   => true,
                'max'      => 40,
            ]
        ],
        'website' => []
    ];

    /**
     * Get all of the rules.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->rules;
    }

    /**
     * Retrieve a rule for the field.
     *
     * @param  string  $key
     * @param  string|array|null  $default
     * @return mixed
     */
    public function get(string $key = null, $default = null)
    {
        return data_get($this->all(), $key, $default);
    }

    /**
     * Set a rule.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function set(string $key, $value)
    {
        return data_set($this->rules, $key, $value);
    }

    /**
     * Get a subset of the rules for the field.
     *
     * @param  string  $field
     * @param  array|mixed $keys
     * @return array
     */
    public function only(string $field, $keys): array
    {
        $keys = is_array($keys) ? $keys : [$keys];

        $rules = [];

        $input = $this->all();

        foreach ($keys as $key) {
            data_set($rules, $key, data_get($input, "{$field}.{$key}"));
        }

        return $this->format($rules);
    }

    /**
     * Format rules as a string.
     *
     * @param  mixed  $rules
     * @return array
     */
    public function format($rules): array
    {
        $rules = is_array($rules) ? $rules : func_get_args();

        $response = [];

        foreach ($rules as $name => $value) {
            if (is_bool($value)) {
                $response[] = $value ? $name : '';
            } else {
                if (is_array($value)) {
                    $value = implode(',', $value);
                }

                $response[] = "{$name}:{$value}";
            }
        }

        return $response;
    }
}
