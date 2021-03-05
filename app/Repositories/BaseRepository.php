<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $createAttributes = [];
    protected $updateAttributes = [];

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return mixed
     */
    abstract public function getModel();


    /**
     * @param $request
     * @return array
     */
    abstract public function getUpdateAttributes($request);


    /**
     * @param $request
     * @return array
     */
    abstract public function getCreateAttributes($request);


    abstract public function onBeforeCreate();


    abstract public function onAfterCreate();


    abstract public function onBeforeUpdate();


    abstract public function onAfterUpdate();


    /**
     * Set model to repository
     */
    public function setModel() {
        $this->model = app()->make(
            $this->getModel()
        );
    }


    /**
     * @param int $limit
     * @return mixed
     */
    public function getAll($limit = 0)
    {
        if ($limit === 0) {
            return $this->_prepare()->get();
        } else {
            return $this->_prepare()->take($limit)->get();
        }
    }


    /**
     * @param $limit
     * @return mixed
     */
    public function getAllByPosition($limit) {
        if ($limit === 0) {
            return $this->_prepare()->orderBy('position', 'asc')->get();
        } else {
            return $this->_prepare()->orderBy('position', 'asc')->take($limit)->get();
        }
    }


    /**
     * @return mixed
     */
    protected function _prepare() {
        return $this->model->where('creator_id', Auth::id());
    }


    /**
     * @param $id
     * @return mixed
     */
    public function single($id) {
        $result = $this->findSingle($id);
        return $result->release(true);
    }


    /**
     * @param $id
     * @return mixed
     */
    private function findSingle($id) {
        return $this->_prepare()->where('id', $id)->first();
    }


    /**
     * @param array $attributes
     * @return mixed|void
     */
    public function create($attributes = [])
    {
        $result = $this->model->create($attributes);
        return $result->release(true);
    }


    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     * @throws Exception
     */
    public function update($id, $attributes = [])
    {
        $result = $this->findSingle($id);

        if ($result) {
            if ($result->update($attributes)) {
                return $result->release(true);
            }
        }

        throw new Exception(__('Resource not found'));
    }


    /**
     * @param $id
     * @return bool|mixed
     * @throws Exception
     */
    public function delete($id)
    {
        $result = $this->findSingle($id);

        if ($result) {
            $result->delete();
            return true;
        }

        throw new Exception(__('Resource not found'));
    }


    /**
     * @param $isUpdateRequest
     * @return array
     */
    public function validator($isUpdateRequest = false)
    {
        return [];
    }
}