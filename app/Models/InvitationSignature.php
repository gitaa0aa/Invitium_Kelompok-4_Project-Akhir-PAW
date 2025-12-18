<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvitationSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'file_path',
        'signer_position',
        'signer_name',
        'signer_identity',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
