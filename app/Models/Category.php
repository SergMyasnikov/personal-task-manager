<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    public function user() {
	return $this->belongsTo(User::class);
    }
    
    public function timeBlocks() {
	return $this->hasMany(TimeBlock::class);
    }
    
    public function subcategories() {
	return $this->hasMany(Subcategory::class);
    }
    
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
