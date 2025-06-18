<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;

/**
 * @OA\Schema(
 *     schema="Student",
 *     type="object",
 *     title="Estudiante",
 *     required={"name", "email", "phone", "language"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Juan Pérez"),
 *     @OA\Property(property="email", type="string", example="juan@email.com"),
 *     @OA\Property(property="phone", type="string", example="3001234567"),
 *     @OA\Property(property="language", type="string", example="Spanish"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Student extends Authenticable implements JWTSubject
{
    use HasFactory;

    protected $table = 'student';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'language',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
