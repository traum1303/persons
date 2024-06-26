<?php
declare(strict_types=1);

namespace App\Models;

use App\Enum\PersonGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string $primaryKey
     */
    protected $primaryKey = 'id';

    /**
     * The table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'mobile_number',
        'email',
        'city',
        'login',
        'car_model',
        'salary'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string> $casts
     */
    protected $casts = [
        'gender' => PersonGender::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     *
     * public function city(): \Illuminate\Database\Eloquent\Relations\HasOne
     * {
     *    return $this->hasOne(City::class, 'id', 'city_id');
     * }
     *
     * public function cars(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * {
     *    return $this->belongsToMany(Car::class, 'person_cars', 'car_id', 'person_id', 'id', 'id')
     *       ->withPivot(['model', 'price', 'color']); //... and other car's attributes related to the person's car
     * }
     *
     */
}
