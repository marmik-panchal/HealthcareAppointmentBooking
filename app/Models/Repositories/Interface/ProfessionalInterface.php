<?php

namespace App\Models\Repositories\Interface;

use Illuminate\Database\Eloquent\Collection;

/**
 * A simple interface to set the methods in our User repository, nothing much happening here
 */
interface ProfessionalInterface
{
    public function getAll(): Collection;
}
