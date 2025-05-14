<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoreRole extends Entities
{
    public const SUPERADMIN         = '50155a72-23c4-4de3-b110-822853fb0deb';

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function users(): HasMany
    {
        return $this->hasMany(CoreUser::class, 'role_id', 'id');
    }

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(CoreMenuAbility::class, 'core_privileges', 'role_id', 'ability_id');
    }

    public function scopeWithAll($query)
    {
        return $query->with('abilities.menu');
    }
}
