<?php

namespace NigelHeap\Roles\Models;


use NigelHeap\Roles\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

use NigelHeap\Roles\Traits\RoleHasRelations;
use NigelHeap\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;

class Role extends Model implements RoleHasRelationsContract
{
    use Sluggable, RoleHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'group'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

}