<?php

namespace App\Http\Controllers;

// Vendors
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Exceptions
use Exception;
use Illuminate\Validation\ValidationException;

/**
 * Class AppControllerAbstract
 * @package App\Http\Controllers
 */
abstract class AppControllerAbstract extends Controller implements ControllerInterface
{
    protected $request;
    protected $repository;


    /**
     * @param Request $request
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }


    /**
     * @param $repository
     */
    public function setRepository($repository) {
        $this->repository = $repository;
    }


    /**
     * Set authorization guard
     */
    public function authGuard() {
        $this->middleware('auth');
    }


    /**
     * @param int|null $id
     * @return JsonResponse|mixed
     */
    public function get($id = null) {
        try {
            if (is_null($id)) {
                $data = $this->repository->getAll();
            } else {
                $data = $this->repository->single($id);
            }
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function getByPosition($id) {
        try {
            if (is_null($id)) {
                $data = $this->repository->getAllByPosition();
            } else {
                $data = $this->repository->single($id);
            }
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * @return JsonResponse|mixed
     */
    public function store()
    {
        try {
            // Try to validate user input
            $this->validate($this->request, $this->repository->validator());

            // Get and validate data
            $attributes = $this->repository->getCreateAttributes($this->request);

            // Trigger before create
            $this->repository->onBeforeCreate();

            // Create a new record
            $data = $this->repository->create($attributes);

            // Trigger after create
            $this->repository->onAfterCreate();

            // Time to response a data object
            return $this->responseSuccess($data);
        } catch (ValidationException $e) {
            return $this->responseError($e->errors());
        } catch (ModelNotFoundException $e) {
            return $this->responseError($e);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function update($id)
    {
        try {
            // Try to validate user input
            $this->validate($this->request, $this->repository->validator(true));

            // Get and validate data
            $attributes = $this->repository->getUpdateAttributes($this->request);

            // Trigger before update
            $this->repository->onBeforeUpdate();

            // Update a exists record
            $data = $this->repository->update($id, $attributes);

            // Trigger after update
            $this->repository->onAfterUpdate();

            // Time to response a data object
            return $this->responseSuccess($data);
        } catch (ValidationException $e) {
            return $this->responseError($e->errors());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }


    /**
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function delete($id) {
        try {
            $this->repository->delete($id);
            return $this->responseMsg(__('Deleted successfully!'));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

}