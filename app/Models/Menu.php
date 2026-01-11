<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['vendor_id', 'nama_makanan', 'harga', 'foto', 'deskripsi', 'tersedia'];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}

