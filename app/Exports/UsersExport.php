<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return User::select('nama', 'npm_nidn_npak', 'email')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NPM NIDN NPAK',
            'Email',
        ];
    }
}
