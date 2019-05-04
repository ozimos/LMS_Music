<?php

namespace Tests;

use App\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\DB;

abstract class ControllerTestCase extends DBTestCase
{
    protected $user;

    /**
     * Setup the DB before each test.
     */
    public function setUp(): void
    {
        parent::setUp();
        $user = User::first();
        if (!$user) {
            $user = factory(User::class)->create(['name' => 'Test User']);
        }

        $this->actingAs($user, 'api');
        $this->user = $user;
    }
    /**
     * Setup the Token Headers
     *
     * @param User $user
     *
     * @return array
     */
    public static function getHeaders(User $user)
    {
        $header = [];
        $header['Accept'] = 'application/json';
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://bridgeanalytics.cj/callback'
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime,
        ]);
        $token = $user->createToken('TestToken')->accessToken;
        $header['Authorization'] = 'Bearer ' . $token;

        return $header;
    }
}
