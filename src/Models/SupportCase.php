<?php

namespace Inventas\ContactSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inventas\ContactSupport\Database\Factories\SupportCaseFactory;
use Inventas\ContactSupport\Events\SupportCaseCreated;
use Inventas\ContactSupport\SupportCaseTypeResolver;

class SupportCase extends Model
{
    use HasFactory;

    protected $casts = [
        'extras' => 'array',
        'closed_at' => 'timestamp',
    ];

    protected $dispatchesEvents = [
        'created' => SupportCaseCreated::class,
    ];

    protected static function newFactory()
    {
        return SupportCaseFactory::new();
    }

    protected $guarded = ['id'];

    public function scopeClosed($query)
    {
        return $query->whereNotNull('closed_at');
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('closed_at');
    }

    public function getSubject(): string
    {
        $config = SupportCaseTypeResolver::type($this->type);

        return '(#'.$this->id.') '.$config['subject_prefix'].' '.$this->name;
    }

    public function getReplyTo(): string
    {
        return $this->email;
    }

    public function getRawContent(): string
    {

        $mailContent = '';

        $config = SupportCaseTypeResolver::type($this->type);

        $mailContent .= "ID: #$this->id\n";
        $mailContent .= 'Channel: '.$config['name']."\n";
        $mailContent .= 'Name: '.$this->name."\n";
        $mailContent .= 'Email: '.$this->email."\n";

        if ($this->phone) {
            $mailContent .= 'Phone: ' . $this->phone."\n";
        }

        if ($this->extras && array_key_exists('company', $this->extras)) {
            $mailContent .= 'Company: ' . $this->extras['company'] . "\n";
        }

        if ($this->extras && array_key_exists('number_of_customers', $this->extras)) {
            $mailContent .= 'Number of customers: ' . $this->extras['number_of_customers'] . "\n";
        }

        if ($this->extras && array_key_exists('manufacturer', $this->extras)) {
            $mailContent .= 'Manufacturer: ' . $this->extras['manufacturer']."\n";
        }
        if ($this->extras && array_key_exists('model', $this->extras)) {
            $mailContent .= 'Model: ' . $this->extras['model']."\n";
        }

        $mailContent .= "\n\n";

        if ($this->message) {
            $mailContent .= ''.$this->message."\n";
        }

        return str($mailContent)->trim()->toString();
    }
}
