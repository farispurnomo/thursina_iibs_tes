<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MstSantri extends Entities
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis',
        'nama',
        'alamat',
        'asrama_id',
        'total_paket'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function updateTotalPaket()
    {
        $this->update([
            'total_paket' => $this->pakets->count()
        ]);
    }

    public function asrama(): BelongsTo
    {
        return $this->belongsTo(MstAsrama::class, 'asrama_id', 'id');
    }

    public function pakets(): HasMany
    {
        return $this->hasMany(TPaket::class, 'penerima_id', 'id');
    }
}
