<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SongRequest extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $table = 'song_requests';

    protected $fillable = [
        'id',
        'id_event',
        'id_table',
        'sender_name',
        'sender_email',
        'sender_unique_char',
        'ip_address',
        'song_name',
        'artist_name',
        'flag_done'
    ];

    protected $casts = [
        'id' => 'string', // UUID is a string
        'flag_done' => 'boolean',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function table()
    {
        return $this->hasOne(Tables::class, 'id', 'id_table');
    }

}
