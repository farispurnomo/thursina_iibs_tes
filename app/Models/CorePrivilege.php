<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorePrivilege extends Model
{
    protected $primaryKey = ['ability_id', 'role_id'];
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ability_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    public function ability(): BelongsTo
    {
        return $this->belongsTo(CoreMenuAbility::class, 'ability_id', 'id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(CoreRole::class, 'role_id', 'id');
    }
}
