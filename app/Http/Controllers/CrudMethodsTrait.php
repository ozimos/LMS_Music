<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
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
        $model = $this->repository->all();
        return response()->json([
            'data' => $model,
            'count' => count($model)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $formRequest
     *
     * @return JsonResponse
     *
     */
    protected function storeFromFormCreateRequest(FormRequest $formRequest)
    {
        $model = $this->repository->create($formRequest->all());

        $response = [
            'message' => 'Model created.',
            'data'    => $model->toArray(),
        ];
        return response()->json($response, 201);
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
        return response()->json([
            'data' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return JsonResponse
     */
    public function search()
    {
        $field = request()->query('field');
        $value = request()->query('value');

        $model = $this->repository->findByField($field, $value);
        return response()->json([
            'data' => $model,
        ]);
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
    protected function updateFromFormUpdateRequest(FormRequest $formRequest, $id)
    {
        $model = $this->repository->update($formRequest->all(), $id);

        $response = [
            'message' => 'Model updated.',
            'data'    => $model->toArray(),
        ];

        return response()->json($response);
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
        $deleted = $this->repository->delete($id);
        return response()->json([
            'message' => 'Model deleted.',
            'deleted' => $deleted,
        ]);
    }

    /**
     * Return the Model Name.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->repository->model();
    }
}
