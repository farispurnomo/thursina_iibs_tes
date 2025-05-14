<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TPaket extends Entities
{
    public const STATE_BELUM    = 'belum';
    public const STATE_DIAMBIL  = 'diambil';

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'tgl_diterima',
        'kategori_id',
        'asrama_id',
        'penerima_id',
        'pengirim',
        'isi_yg_disita',
        'status'
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::created(function (TPaket $model) {
            $model->penerima->updateTotalPaket();
        });

        self::updated(function (TPaket $model) {
            $model->penerima->updateTotalPaket();

            if ($model->isDirty('penerima_id')) {
                $old_penerima_id = $model->getOriginal('penerima_id');
                MstSantri::find($old_penerima_id)->updateTotalPaket();
            }
        });

        self::deleted(function (TPaket $model) {
            $model->penerima->updateTotalPaket();
        });
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MstKategoriPaket::class, 'kategori_id', 'id');
    }

    public function asrama(): BelongsTo
    {
        return $this->belongsTo(MstAsrama::class, 'asrama_id', 'id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(MstSantri::class, 'penerima_id', 'id');
    }
}
