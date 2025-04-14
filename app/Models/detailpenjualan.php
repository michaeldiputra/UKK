<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailpenjualan extends Model
{
    public function penjualan(){
        return $this->belongsTo(Penjualan::class);
    }

    public function produk(){
        return $this->belongsTo(Produk::class);
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class);
    }

    protected static function booted(){
        static::created(function($detailpenjualan){
            $produk = Produk::find($detailpenjualan->produk_id);
            if ($produk){
                $produk->stok -= $detailpenjualan->jumlah_produk;
                $produk->save();
            }

            self::updateTotalPenjualan($detailpenjualan->penjualan_id);
        });
        
        static::deleted(function($detailpenjualan){
            $produk = Produk::find($detailpenjualan->produk_id);
            if ($produk){
                $produk->stok += $detailpenjualan->jumlah_produk;
                $produk->save();
            }

            self::updateTotalPenjualan($detailpenjualan->penjualan_id);
        });

    }

    private static function updateTotalPenjualan($penjualan_id){
        $total = self::where('penjualan_id', $penjualan_id)->sum('subtotal');

        $penjualan = Penjualan::find($penjualan_id);
        if ($penjualan) {
            $penjualan->total_harga = $total;
            $penjualan->save();
        }
    }
}
