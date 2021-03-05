<?php

namespace App\Http\Controllers;

/**
 * Interface ControllerInterface
 * @package App\Http\Controllers
 */
interface ControllerInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);


    /**
     * @return mixed
     */
    public function store();


    /**
     * @param $id
     * @return mixed
     */
    public function update($id);


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}