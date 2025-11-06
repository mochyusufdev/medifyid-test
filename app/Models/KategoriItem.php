<?php

namespace App\Models;

use App\Models\MasterItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriItem extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function masterItems()
    {
        return $this->hasMany(MasterItem::class, 'kategori_id');
    }
}
