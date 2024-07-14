<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'nama' => $row['nama'],
            'npm_nidn_npak' => $row['npm_nidn_npak'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'jabatan' => $row['jabatan'],
            'unit_kerja' => $row['unit_kerja'],
            'jurusan' => $row['jurusan'],
            'prodi' => $row['prodi'],
        ]);
    }
}
