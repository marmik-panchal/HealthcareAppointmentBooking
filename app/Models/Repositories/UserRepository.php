<?php

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\User;
use App\Models\Repositories\Interface\UserInterface;

/**
 * Our repository, containing commonly used queries
 */
class UserRepository implements UserInterface
{
    // Our Eloquent model
    protected $model;

    /**
     * Setting our class $model to the injected model
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the user object associated with the passed id
     *
     * @param array $request
     * @return Model
     */
    public function createUser(array $request): Model
    {
        return $this->model->create($request);
    }
}
