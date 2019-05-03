<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtisteCreateRequest;
use App\Http\Requests\ArtisteUpdateRequest;
use App\Contracts\Repositories\ArtisteRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class ArtistesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ArtistesController extends Controller
{
    use CrudMethodsTrait;

    /**
     * @var ArtisteRepository
     */
    protected $artisteRepository;

    /**
     * ArtistesController constructor.
     *
     * @param ArtisteRepository $artisteRepository
     */
    public function __construct(ArtisteRepository $artisteRepository)
    {
        $this->artisteRepository = $artisteRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArtisteCreateRequest $artisteCreateRequest
     *
     * @return JsonResponse
     *
     */
    public function store(ArtisteCreateRequest $artisteCreateRequest)
    {
        return $this->storeFromFormCreateRequest($artisteCreateRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArtisteUpdateRequest $artisteUpdateRequest
     * @param  string            $id
     *
     * @return JsonResponse
     *
     */
    public function update(ArtisteUpdateRequest $artisteUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($artisteUpdateRequest, $id);
    }
}
