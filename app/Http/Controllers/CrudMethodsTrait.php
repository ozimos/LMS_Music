<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Collection;
use Prettus\Repository\Criteria\RequestCriteria;

trait CrudMethodsTrait
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $this->repository->pushCriteria(app(RequestCriteria::class));
        $models = $this->repository->all();
        return $this->respondWithCollection($models);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $formRequest
     *
     * @return JsonResponse
     *
     */
    protected function storeFromFormCreateRequest($formRequest)
    {
        $model = $this->repository->create($formRequest->all());
        return $this->respondWithItem($model)->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository->find($id);
        return $this->respondWithItem($model);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @codeCoverageIgnore
     * 
     * @return JsonResponse
     */
    public function search()
    {
        $field = request()->query('field');
        $value = request()->query('value');

        $model = $this->repository->findByField($field, $value);
        return $this->respondWithItem($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FormRequest $formRequest
     * @param  string            $id
     *
     * @return JsonResponse
     *
     */
    protected function updateFromFormUpdateRequest($formRequest, $id)
    {
        $model = $this->repository->find($id);
        if (Gate::denies('update-model', $model)) {
            return response()->json(['error' => 'UnAuthorized'], 403);
        }
        $model = $this->repository->update($formRequest->all(), $id);
        return $this->respondWithItem($model);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $model = $this->repository->find($id);

        Gate::before(function ($user) {
            if ($user->isAdmin) {
                return true;
            }
        });
        
        if (Gate::denies('delete-model', $model)) {
            return response()->json(['error' => 'UnAuthorized'], 403);
        }

        $deleted = $this->repository->delete($id);
        return response()->json([
            'message' => 'Model deleted.',
            'deleted' => $deleted,
        ]);
    }

    /**
     * Return the Model Name.
     * 
     * @codeCoverageIgnore
     * 
     * @return string
     */
    public function getModel()
    {
        return $this->repository->model();
    }
}
