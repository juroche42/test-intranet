<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *    schema="User",
 *    required={"email", "username", "nom", "prenom", "poste", "status"},
 *      @OA\Property(property="id", type="integer", format="int64"),
 *      @OA\Property(property="email", type="string"),
 *      @OA\Property(property="username", type="string"),
 *      @OA\Property(property="nom", type="string"),
 *      @OA\Property(property="prenom", type="string"),
 *      @OA\Property(property="poste", type="string"),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'nom',
        'prenom',
        'poste',
        'status',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_to_service', 'user_id', 'service_id');
    }
}
