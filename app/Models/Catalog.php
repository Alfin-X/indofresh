<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_produk';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_produk',
        'nama',
        'stock',
        'keterangan',
        'harga',
        'gambar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'integer',
        'stock' => 'integer',
    ];

    /**
     * Get transaction items for this catalog
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'catalog_id_produk', 'id_produk');
    }

    /**
     * Scope a query to only include active catalogs
     */
    public function scopeActive($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include catalogs with stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
