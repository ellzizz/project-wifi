<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasangan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'alamat', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
