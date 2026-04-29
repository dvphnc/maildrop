<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'sender_name',
        'recipient_email',
        'message',
        'attachment',
        'amount',
        'status',
    ];
}