<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name','logo','email','description'];

     public function adminInvite()
    {
        return $this->hasOne(SuperAdminInvite::class,'company_id');
    }

    public function hasManagers()
    {
        return $this->hasMany(User::class, 'company_id')
            ->whereHas('hasRole', function ($q) {
                $q->where('slug', 'manager');
            });
    }
}
