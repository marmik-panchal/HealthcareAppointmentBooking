<?php

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Professional;
use App\Models\Repositories\Interface\ProfessionalInterface;

/**
 * Our repository, containing commonly used queries
 */
class ProfessionalRepository implements ProfessionalInterface
{
    // Our Eloquent model
    protected $model;

    /**
     * Setting our class $model to the injected model
     *
     * @param Professional $model
     */
    public function __construct(Professional $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the user object associated with the passed id
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->get();
    }
}
