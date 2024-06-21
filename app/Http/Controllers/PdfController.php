<?php
namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class PdfController extends Controller
{
    public function cetakPdf($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);

        $path = storage_path('app/public/bukti');
        $files = File::files($path); // Penggunaan yang benar dari alias File

        $imagePath=public_path('public\storage\bukti\9OZggbXpAW1hD4Q5afGA987AIQe4BPDTmpbjvXRG.png');

        $images = [];
        foreach ($files as $file) {
            $images[] = $file->getPathname();
        }

        $data = [
            'images' => $images,
        ];

        // Jika Anda ingin menggabungkan data dari $pelaporan dan gambar dalam satu PDF,
        // Anda harus menggabungkannya dalam satu view. Misal, di view 'pdf_view'.
        $pdf = Pdf::loadView('satgas.detail-pelaporan-pdf', compact('pelaporan', 'data'));

        return $pdf->download('satgas.detail-pelaporan-pdf'.$id.'.pdf');
    }
}


