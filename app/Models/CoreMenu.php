<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoreMenu extends Entities
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'icon',
        'parent_id',
        'url',
        'order',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CoreMenu::class, 'parent_id', 'id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(CoreMenu::class, 'parent_id', 'id')->orderBy('order');
    }

    public function abilities(): HasMany
    {
        return $this->hasMany(CoreMenuAbility::class, 'menu_id', 'id');
    }

    public function allChilds()
    {
        return $this->childs()->with('abilities')->with('allChilds')->where('is_show', true);
    }

    public function scopeChildless($q)
    {
        return $q->whereNull('parent_id')->orderBy('order');
    }
}
