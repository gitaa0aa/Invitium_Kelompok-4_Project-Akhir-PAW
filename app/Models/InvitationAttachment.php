<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvitationAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'file_path',
        'original_name',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
