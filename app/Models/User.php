<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rfc',
        'level',
        'experience',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
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
        static::created(function ($user) {
            // Ensure wallet exists
            $user->wallet()->create(['balance' => 0]);

            // Generate simulated RFC if not present
            if (!$user->rfc) {
                $initials = strtoupper(substr($user->name, 0, 4));
                if (strlen($initials) < 4) {
                    $initials = str_pad($initials, 4, 'X');
                }
                $date = now()->format('ymd');
                $random = strtoupper(Str::random(3));
                $user->rfc = "{$initials}{$date}{$random}";
                $user->save();
            }
            
            // Asignar rol de 'alumno' automáticamente si no tiene ningún rol
            // Los admins y docentes se crean con roles específicos desde el seeder o panel admin
            if (!$user->hasAnyRole(['admin', 'docente', 'alumno'])) {
                $user->assignRole('alumno');
            }
        });
    }

    public function addExperience(int $points)
    {
        $this->experience += $points;
        $this->calculateLevel();
        $this->save();
    }

    protected function calculateLevel()
    {
        // Simple level logic: every 100 XP is a level
        $newLevel = floor($this->experience / 100) + 1;
        
        if ($newLevel > $this->level) {
            $this->level = $newLevel;
            // Potencial logic for level-up notification
        }
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
