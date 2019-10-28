<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class AbstractRepository extends BaseRepository
{
    private $selectedUser = null;

    private function whereSelected() {
        if(!is_null($this->selectedUser)) {
            $this->model = $this->model->where('user_id', $this->selectedUser);
        }
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes) {
        if(!is_null($this->selectedUser)) {
            $attributes['user_id'] = isset($attributes['user_id']) ? $attributes['user_id'] : $this->selectedUser;
        }

        return parent::create($attributes);
    }

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []) {
        if(!is_null($this->selectedUser)) {
            $attributes['user_id'] = isset($attributes['user_id']) ? $attributes['user_id'] : $this->selectedUser;
        }

        return parent::updateOrCreate($attributes, $values);
    }

    /**
     * Retrieve first data of repository, or return new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = []) {
        if(!is_null($this->selectedUser)) {
            $attributes['user_id'] = isset($attributes['user_id']) ? $attributes['user_id'] : $this->selectedUser;
        }

        return parent::firstOrNew($attributes);
    }

    /**
     * Retrieve first data of repository, or create new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = []) {
        if(!is_null($this->selectedUser)) {
            $attributes['user_id'] = isset($attributes['user_id']) ? $attributes['user_id'] : $this->selectedUser;
        }

        return parent::firstOrCreate($attributes);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return void
     */
    protected function applyConditions(array $where)
    {
        if(!is_null($this->selectedUser)) {
            $where['user_id'] = isset($where['user_id']) ? $where['user_id'] : $this->selectedUser;
        }

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $this->whereSelected();
        return parent::findWhereIn($field, $values, $columns);
    }

    public function withUser($userId = null) {
        $this->selectedUser = is_int($userId) ? $userId : (int)auth()->id();
        return $this;
    }

    public function resetUser() {
        $this->selectedUser = null;
        return $this;
    }
}
