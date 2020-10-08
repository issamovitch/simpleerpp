<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingListEmail extends Model
{
    use HasFactory;

    protected $appends = ["values"];

    public function values_not_keyed(){
        return $this->hasMany("App\Models\MailingListEmailValue", "mailing_list_email_id");
    }

    public function getValuesAttribute(){
        return $this->values_not_keyed->keyBy("mailing_list_field_id");
    }

}
