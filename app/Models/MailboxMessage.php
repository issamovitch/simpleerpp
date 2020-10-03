<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailboxMessage extends Model
{
    use HasFactory;

    public function user_from(){
        return $this->belongsTo("App\Models\User", "from");
    }

    public function user_to(){
        return $this->belongsTo("App\Models\User", "to");
    }

    public function label(){
        return $this->belongsTo("App\Models\MailboxLabel", "label_id");
    }

    public function attachments()
    {
        return $this->morphMany("\App\Models\Attachment" , 'attachmentable');
    }

}
