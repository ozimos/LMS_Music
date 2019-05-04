<?php
namespace App\Contracts;

interface ResponseInterface
{
    public function respondWithCollection($models);

    public function respondWithItem($model);
}
