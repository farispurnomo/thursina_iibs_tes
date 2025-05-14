<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class CoreUser extends Entities implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, HasApiTokens, Notifiable, CanResetPassword;

    protected $keyType = 'string';
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'image',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // The customization of the email happens here
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // The trick is first to instantiate the notification itself
        $notification = new PasswordResetNotification($token);
        // Then use the createUrlUsing method
        // $notification->createUrlUsing(function ($notifiable, $token) {
        //     return url(route('client.password.reset', [
        //         'token' => $token,
        //         'email' => $notifiable->getEmailForPasswordReset()
        //     ], false));
        // });

        // Then you pass the notification
        $this->notify($notification);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $deleteFile = function ($filename) {
            if (Storage::exists($filename)) {
                Storage::delete($filename);
            }
        };

        self::updating(function (CoreUser $model) use ($deleteFile) {
            if ($model->isDirty('image')) {
                if ($image = $model->getOriginal('image')) {
                    $deleteFile($image);
                }
            }
        });

        self::deleting(function (CoreUser $model) use ($deleteFile) {
            if ($model->image) {
                $deleteFile($model->image);
            }
        });
    }

    protected $appends = ['url_image'];
    public function getUrlImageAttribute()
    {
        return ($this->image) ? Storage::url($this->image) : URL::to('images/no_image.png');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(CoreRole::class, 'role_id', 'id');
    }
}
