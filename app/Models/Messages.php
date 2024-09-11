<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'id_event',
        'id_table',
        'sender_name',
        'sender_email',
        'sender_unique_char',
        'content',
        'ip_address',
    ];

    public function table()
    {
        return $this->hasOne(Tables::class, 'id', 'id_table');
    }
}
