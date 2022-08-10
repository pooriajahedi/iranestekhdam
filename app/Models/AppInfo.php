<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    use HasFactory;
    protected $hidden=['id','created_at','updated_at'];
    protected $fillable=['app_version','update_note','download_url','force_update','resume_url','share_text','about_text','address','email','website','tel','telegram_id','whats_app_number'];
}
