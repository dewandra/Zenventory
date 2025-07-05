<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryBatch;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function exportInventoryAging()
    {
        return new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // Header kolom
            fputcsv($handle, [
                'Produk',
                'SKU',
                'LPN',
                'Lokasi',
                'Kuantitas',
                'Tanggal Terima',
                'Umur Stok (Hari)',
                'Tanggal Kedaluwarsa'
            ]);

            // Ambil data dan tulis baris per baris
            InventoryBatch::with(['product', 'location'])
                ->where('quantity', '>', 0)
                ->orderBy('received_date', 'asc')
                ->chunk(200, function ($batches) use ($handle) {
                    foreach ($batches as $batch) {
                        fputcsv($handle, [
                            $batch->product->name,
                            $batch->product->sku,
                            $batch->lpn,
                            $batch->location->name,
                            $batch->quantity,
                            $batch->received_date->format('Y-m-d'),
                            now()->diffInDays($batch->received_date),
                            $batch->expiry_date ? $batch->expiry_date->format('Y-m-d') : 'N/A',
                        ]);
                    }
                });

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inventory_aging_report_' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}