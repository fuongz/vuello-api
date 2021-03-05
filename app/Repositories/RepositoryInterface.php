<?php

namespace App\Repositories;

use Illuminate\Http\Request;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param boolean $isUpdateRequest
     * @return array
     */
    public function validator($isUpdateRequest = false);


    /**
     * @param Request $request
     * @return array
     */
    public function getUpdateAttributes(Request $request);


    /**
     * @param Request $request
     * @return array
     */
    public function getCreateAttributes(Request $request);


    /**
     * @return mixed
     */
    public function getAll();


    /**
     * @param $id
     * @return mixed
     */
    public function single($id);


    /**
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     */
    public function onBeforeCreate();


    /**
     */
    public function onAfterCreate();


    /**
     */
    public function onBeforeUpdate();


    /**
     */
    public function onAfterUpdate();
}
