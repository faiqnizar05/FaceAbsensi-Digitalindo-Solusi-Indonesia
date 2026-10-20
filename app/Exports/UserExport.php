<?php

namespace App\Exports;

use App\Models\UserData;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return UserData::orderBy('id', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Register',
            'Departement',
            'Nama',
            'No Telepon',
            'Tanggal Mulai',
        ];
    }

    public function map($user): array
    {
        static $no = 0;

        $no++;

        return [
            $no,
            $user->register ?? '-',
            $user->departement ?? '-',
            $user->nama ?? '-',
            $user->no_telepon ?? '-',
            $user->tanggal_mulai
                ? Carbon::parse($user->tanggal_mulai)->format('d-m-Y')
                : '-',
        ];
    }
}