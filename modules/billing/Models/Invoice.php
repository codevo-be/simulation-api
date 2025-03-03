<?php

namespace Diji\Billing\Models;

use App\Traits\AutoloadRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Invoice extends Model
{
    public const STATUS_DRAFT = "draft";
    public const STATUS_PENDING = "pending";
    public const STATUS_PAYED = "payed";
    public const STATUS_EXPIRED = "expired";

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PENDING,
        self::STATUS_PAYED,
        self::STATUS_EXPIRED
    ];

    use HasFactory, AutoloadRelationships;

    protected $fillable = [
        "status",
        "issuer",
        "date",
        "due_date",
        "payment_date",
        "subtotal",
        "taxes",
        "total",
        "contact_name",
        "vat_number",
        "email",
        "phone",
        "street",
        "street_number",
        "city",
        "zipcode",
        "country",
        "contact_id"
    ];

    protected $casts = [
        'subtotal' => 'float',
        'taxes' => 'json',
        'total' => 'float',
        'issuer' => 'json'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (!$invoice->due_date) {
                $invoice->due_date = now()->addDays(30);
            }

            if (!$invoice->date) {
                $invoice->date = now();
            }
        });

        static::updating(function($invoice){
            if ($invoice->isDirty('status') && $invoice->getOriginal('status') === 'draft') {
                if (empty($invoice->identifier_number)) {
                    $year = now()->year;

                    $lastOffer = self::whereYear('date', $year)
                        ->whereNotNull('identifier_number')
                        ->orderBy('identifier_number', 'desc')
                        ->first();

                    $nextNumber = $lastOffer ? $lastOffer->identifier_number + 1 : 1;

                    $invoice->identifier_number = $nextNumber;
                    $invoice->identifier = sprintf('%d/%03d', $year, $nextNumber);
                }

                if(empty($invoice->structured_communication)){
                    $invoice->structured_communication = \Diji\Billing\Helpers\Invoice::generateStructuredCommunication($invoice->identifier_number);
                }
            }
        });

        static::deleting(function ($invoice) {
            if (!empty($invoice->identifier)) {
                throw new \Exception("Invoice cannot be deleted !");
            }

            $invoice->items()->delete();
        });
    }

    public function items()
    {
        return $this->morphMany(BillingItem::class, 'model')->orderBy("position");
    }

    public function contact()
    {
        return $this->belongsTo(\Diji\Contact\Models\Contact::class, 'contact_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'model');
    }
}
