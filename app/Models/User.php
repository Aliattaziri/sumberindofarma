<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    // Methods untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isSuperAdmin(): bool
    {
        return $this->isAdmin() && $this->outlet_name === null;
    }

    public function getOutletNameAttribute(): ?string
    {
        return self::mapAdminOutletByEmail($this->email);
    }

    public function isOutletAdmin(): bool
    {
        return $this->outlet_name !== null;
    }

    public static function mapAdminOutletByEmail(string $email): ?string
    {
        return match (strtolower(trim($email))) {
            'alfa.sintang@sumberindofarma.com'       => 'Alfa Sintang',
            'alfa.airupas@sumberindofarma.com'       => 'Alfa Air Upas',
            'alfa.kendawangan@sumberindofarma.com'   => 'Alfa Kendawangan',
            'alfa.balaiberkuak@sumberindofarma.com'  => 'Alfa Balai Berkuak',
            'alfa.nangatayap@sumberindofarma.com'    => 'Alfa Nanga Tayap',
            'alfa.tumbangtiti@sumberindofarma.com'   => 'Alfa Tumbang Titi',
            'alfa.sosok@sumberindofarma.com'         => 'Alfa Sosok',
            'alfa.bodok@sumberindofarma.com'         => 'Alfa Bodok',
            'alfa.kembayan@sumberindofarma.com'      => 'Alfa Kembayan',
            'alfa.ambawang@sumberindofarma.com'      => 'Alfa Ambawang',
            'alfa.jungkat@sumberindofarma.com'       => 'Alfa Jungkat',
            'alfa.mempawah@sumberindofarma.com'      => 'Alfa Mempawah',
            'apotek.medistrafarma@sumberindofarma.com' => 'Apotek Medistra Farma',
            default => null,
        };
    }
}
