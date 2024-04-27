<?php

namespace App\Models\Repositories\Interface;

use Illuminate\Database\Eloquent\Model;

/**
 * A simple interface to set the methods in our User repository, nothing much happening here
 */
interface UserInterface
{
    public function createUser(array $request): Model;
}
