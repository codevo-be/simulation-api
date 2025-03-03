<?php

namespace Diji\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        "firstname",
        "lastname",
        "email",
        "phone",
        "company_name",
        "vat_number",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Contact $contact) {
            if (!$contact->display_name) {
                $contact->display_name = $contact->setDisplayName();
            }
        });

        static::updating(function($contact){
            if ($contact->isDirty('firstname') || $contact->isDirty('lastname') || $contact->isDirty('company_name')) {
                $contact->display_name = $contact->setDisplayName();
            }
        });
    }

    private function setDisplayName()
    {
        if ($this->vat_number) {
            return $this->company_name;
        } else {
            return "{$this->firstname} {$this->lastname}";
        }
    }
}
