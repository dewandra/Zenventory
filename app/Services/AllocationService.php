<?php

namespace App\Services;

use App\Models\InventoryBatch;
use Illuminate\Support\Collection;
use App\Exceptions\InsufficientStockException;

class AllocationService
{
    /**
     * Alokasikan stok untuk produk tertentu.
     * Menggunakan FEFO (First-Expired, First-Out), kemudian FIFO (First-In, First-Out).
     *
     * @param int $productId
     * @param int $quantityNeeded
     * @return \Illuminate\Support\Collection
     * @throws \App\Exceptions\InsufficientStockException
     */
    public function allocate(int $productId, int $quantityNeeded): Collection
    {
        // Ambil semua batch yang tersedia, diurutkan berdasarkan tanggal kedaluwarsa, lalu tanggal penerimaan.
        // Batch tanpa tanggal kedaluwarsa akan diletakkan di akhir.
        $availableBatches = InventoryBatch::with('location') // Eager load relasi lokasi
            ->where('product_id', $productId)
            ->where('quantity', '>', 0)
            ->orderByRaw('expiry_date IS NULL ASC, expiry_date ASC, received_date ASC')
            ->get();

        $totalAvailable = $availableBatches->sum('quantity');

        // Lemparkan exception jika stok tidak cukup
        if ($totalAvailable < $quantityNeeded) {
            throw new InsufficientStockException("Stok tidak mencukupi. Tersedia: {$totalAvailable}, Dibutuhkan: {$quantityNeeded}.");
        }

        $picklist = new Collection();
        $remainingNeeded = $quantityNeeded;

        foreach ($availableBatches as $batch) {
            if ($remainingNeeded <= 0) {
                break;
            }

            $quantityToPick = min($batch->quantity, $remainingNeeded);

            $picklist->push([
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'lpn' => $batch->lpn,
                'location_id' => $batch->location->id,
                'location_name' => $batch->location->name,
                // Tambahkan komponen lokasi untuk pengurutan
                'zone' => $batch->location->zone,
                'aisle' => $batch->location->aisle,
                'rack' => $batch->location->rack,
                'bin' => $batch->location->bin,
                'quantity_to_pick' => $quantityToPick,
                'expiry_date' => $batch->expiry_date,
            ]);

            $remainingNeeded -= $quantityToPick;
        }

        // Urutkan picklist berdasarkan rute gudang (Zone -> Aisle -> Rack -> Bin)
        return $picklist->sortBy('bin')->sortBy('rack')->sortBy('aisle')->sortBy('zone')->values();
    }
}