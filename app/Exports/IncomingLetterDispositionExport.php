<?php

namespace App\Exports;

use App\Models\IncomingLetter;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomingLetterDispositionExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $letter;

    public function __construct(IncomingLetter $letter)
    {
        $this->letter = $letter;
    }

    public function array(): array
    {
        $recipients = $this->letter->recipients->pluck('name')->toArray();
        $recipientRows = [];

        foreach ($recipients as $recipient) {
            $recipientRows[] = [$recipient, '']; // Nama recipient di kolom pertama, kolom kedua kosong
        }

        return array_merge([
            ['No. Agenda', $this->letter->agenda_number],
            ['Tanggal Terima', Carbon::parse($this->letter->received_date)->format('d M Y') . ' - ' . $this->letter->received_time],
            ['Penerima',  $this->letter->recipient],
            ['Tanggal Surat',  Carbon::parse($this->letter->letter_date)->format('d M Y')],
            ['No. Surat',  $this->letter->letter_number],
            ['Perihal',  $this->letter->subject],
            ['Klasifikasi Surat',  $this->letter->classification_letter],
            ['Sifat Surat',  $this->letter->category_letter],
            ['Resume', $this->letter->resume],
            ['Ditujukan Kepada',  'Disposisi / Tindak Lanjut'],
        ], $recipientRows);
    }

    public function headings(): array
    {
        return [
            ['LEMBAR DISPOSISI'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = 11 + count($this->letter->recipients);

        $sheet->mergeCells('A1:B1');

        $sheet->getColumnDimension('B')->setAutoSize(false);
        $sheet->getColumnDimension('B')->setWidth(45);
        $sheet->getStyle('B')->getAlignment()->setWrapText(true);

        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']],
                'alignment' => ['horizontal' => 'center'],
            ],
            11 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']],
                'alignment' => ['horizontal' => 'center']
            ],
            'A1:B' . $rowCount => ['font' => ['size' => 14], 'borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
