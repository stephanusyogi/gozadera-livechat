<?php
namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;  // Make sure this is correct
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Authenticatable  // This is correct for authentication
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, UUID;

    protected $table = 'administrators';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'type',
        'created_by',
        'updated_by',
    ];

    /**
     * Attribute for user role type
     *
     * @var string|null
     */
    // protected $type;

    public function hasRole($roleName)
    {
        return $this->type == $roleName;
    }

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
