<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id', // Pastikan ada kolom ini
        'jenis_paket',
        'name',
        'email',
        'password',
        'rul',
        'phone',
        'position',
        'address',
        'divisi',
        'status',
        

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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->phone = '+62' . ltrim($user->phone, '0'); // Tambahkan +62 dan hilangkan angka 0 di awal
        });
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'user_id', 'id'); // Menggunakan user_id di tabel pembayarans
    }

    public function nilai()
    {
        return $this->hasMany(nilai::class, 'user_id', 'id'); // Menghubungkan id di tabel users ke user_id di tabel nilai
    }
    
}
