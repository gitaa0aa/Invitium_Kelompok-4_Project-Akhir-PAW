<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'email',
        'position',
        'affiliation',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
