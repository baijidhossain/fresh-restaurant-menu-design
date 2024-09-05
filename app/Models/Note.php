<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Searchable;

class Note extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['property', 'asset', 'contact_id'];

    protected $searchableFields = ['*'];

    protected $table = 'notes';
}
