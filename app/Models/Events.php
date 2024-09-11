<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'date',
        'time_start',
        'time_end',
        'encrypted_code',
        'file_barcode',
        'flag_table_security',
        'flag_started',
        'videotron_flag_background',
        'videotron_background_image',
        'videotron_color_code',
        'visitor_flag_background',
        'visitor_background_image',
        'visitor_color_code',
        'bubble_color_code_message_name',
        'bubble_color_code_message_time',
        'bubble_color_code_message_text',
        'bubble_color_code_message_background',
        'bubble_message_font_size',
        'bubble_message_width',
        'created_by',
        'updated_by',
    ];
}
