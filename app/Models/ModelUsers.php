<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ModelUsers extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $primaryKey = "id";
    use Softdeletes;



}
