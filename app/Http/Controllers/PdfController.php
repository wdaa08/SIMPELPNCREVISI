<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function cetakPdf($id)
    {
        $pelaporan = Pelaporan::with('user')->findOrFail($id);
        $user = $pelaporan->user;

        // Path untuk folder bukti
        $path = storage_path('app/public/bukti');
        $files = File::files($path);

        // Path gambar statis
        $imagePath = public_path('storage/bukti/9OZggbXpAW1hD4Q5afGA987AIQe4BPDTmpbjvXRG.png');

        $tanda_tangan = public_path('storage/' . $user->tanda_tangan);
        $bukti = public_path('storage/' . $pelaporan->bukti);

        

        $images = [];
        foreach ($files as $file) {
            $images[] = $file->getPathname();
        }
        
        $data = [
            'images' => $images,
            'tanda_tangan' => $tanda_tangan,
<<<<<<< HEAD
            'bukti' => $bukti
=======
            'bukti' => $bukti,
>>>>>>> 365a057def248517b0b22e7fd5f08542d3c4c010
        ];
        
        $pdf = Pdf::loadView('satgas.detail-pelaporan-pdf', compact('pelaporan', 'data', 'user'))
            ->setPaper('a4')
            ->setWarnings(false)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->download('satgas.detail-pelaporan-pdf-' . $id . '.pdf');
    }
}
