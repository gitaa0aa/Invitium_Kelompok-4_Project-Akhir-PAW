<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_number',
        'letter_date',
        'hal',
        'lampiran_text',
        'kop_path',
        'description',
        'event_date',
        'event_time',
        'event_place',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'event_date'  => 'date',
    ];

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }

    public function attachments()
    {
        return $this->hasMany(InvitationAttachment::class);
    }

    public function signatures()
    {
        return $this->hasMany(InvitationSignature::class);
    }
}
