<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SuperAdminInvite extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['company_id','role_id','name','logo','description','email','token','accepted_at'];

}
