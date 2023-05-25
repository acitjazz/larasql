<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
class AdminPassword extends Model
{
    use HasFactory;
    protected $table = 'admin_passwords';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'admin_id',
        'password',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
