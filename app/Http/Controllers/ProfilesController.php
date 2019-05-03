<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Contracts\Repositories\ProfileRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class ProfilesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProfilesController extends Controller
{
    use CrudMethodsTrait;

    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    /**
     * ProfilesController constructor.
     *
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProfileCreateRequest $profileCreateRequest
     *
     * @return JsonResponse
     *
     */
    public function store(ProfileCreateRequest $profileCreateRequest)
    {
        return $this->storeFromFormCreateRequest($profileCreateRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfileUpdateRequest $profileUpdateRequest
     * @param  string            $id
     *
     * @return JsonResponse
     *
     */
    public function update(ProfileUpdateRequest $profileUpdateRequest, $id)
    {
        return $this->updateFromFormUpdateRequest($profileUpdateRequest, $id);
    }
}
