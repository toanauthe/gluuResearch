<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class PatientUser extends Authenticatable
{

    public const FEMALE = 0;
    public const MALE = 1;
    public const OTHER = 2;

    protected $table = 'patient_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'is_verified',
        'active',
        'gender',
        'phone_number',
        'nationality_id',
        'city_id',
        'activated_at',
        'deactivated_at',
        'password_changed_at',
        'email_verified_at',
        'phone_number_verified_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'changed_password_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'activated_at',
        'deactivated_at',
        'password_changed_at',
        'email_verified_at',
        'phone_number_verified_at',
        'birthday'
    ];
}
