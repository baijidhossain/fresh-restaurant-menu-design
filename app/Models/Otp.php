<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
  use HasFactory;

  protected $fillable = ['token', 'expires_at', 'phone', 'restaurant_user_id'];
}
