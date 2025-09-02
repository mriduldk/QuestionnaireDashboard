<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'survey_id',
        'is_email_verified',
        'email_verified_at',
        'phone',
        'password',
        'otp',
        'otp_valid_upto',
        'fcm_token',
        'is_active',
        'is_delete',

        'district',
        'sub_division',
        'block',
        'vcdc',

        'father_name',
        'village',
        'address',
        'photo',
        'performance',
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

    // App\Models\User.php

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function districtInfo()
    {
        return $this->belongsTo(District::class, 'district');
    }
    public function subDivisionInfo()
    {
        return $this->belongsTo(SubDivision::class, 'sub_division');
    }

    public function blockInfo()
    {
        return $this->belongsTo(Block::class, 'block');
    }

    public function vcdcInfo()
    {
        return $this->belongsTo(Vcdc::class, 'vcdc');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'user_id', 'user_id');
    }


}
