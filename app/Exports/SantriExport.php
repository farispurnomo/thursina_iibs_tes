<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SantriExport implements WithEvents, WithTitle
{
    use Exportable;

    protected Collection $records;

    protected string $headerColor = '10538a';

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function title(): string
    {
        return 'Data';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class   => function (AfterSheet $event) {
                $sheet  = $event->sheet->getDelegate();
                $sheet->setShowGridLines(false);
                $sheet->getSheetView()->setZoomScale(110);
                $sheet->freezePane('A4');

                // set title
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'Data Santri');
                $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(15);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(45);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(10);

                // start Header
                $row    = 3;
                $sheet
                    ->setCellValue('A' . $row,       'No.')
                    ->setCellValue('B' . $row,       'NIS')
                    ->setCellValue('C' . $row,       'Nama')
                    ->setCellValue('D' . $row,       'Alamat')
                    ->setCellValue('E' . $row,       'Asrama')
                    ->setCellValue('F' . $row,       'Total Paket');

                $cell   = 'A' . $row . ':F' . $row;
                $sheet->getStyle($cell)->getAlignment()->setWrapText(true);
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
                $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->headerColor);
                $sheet->getStyle($cell)->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $row    = 4;
                if ($this->records->isEmpty()) {
                    $cell   = 'A' . $row;
                    $sheet->mergeCells($cell . ':F' . $row);
                    $sheet->setCellValue($cell, 'Tidak Ada Data');
                    $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    $row++;
                } else {
                    foreach ($this->records as $key => $record) {
                        $sheet
                            ->setCellValueExplicit('A' . $row, $key + 1,                    DataType::TYPE_NUMERIC)
                            ->setCellValueExplicit('B' . $row, $record->nis,                DataType::TYPE_STRING2)
                            ->setCellValueExplicit('C' . $row, $record->nama,               DataType::TYPE_STRING2)
                            ->setCellValueExplicit('D' . $row, $record->alamat,             DataType::TYPE_STRING2)
                            ->setCellValueExplicit('E' . $row, $record->asrama->nama ?? '', DataType::TYPE_STRING2);

                        $sheet->setCellValue('F' . $row, $record->total_paket);

                        $cell   = 'A' . $row . ':F' . $row;
                        $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                        $sheet->getStyle($cell)->getAlignment()->setWrapText(true);

                        $row++;
                    }
                }
                $row--;
                $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
            }
        ];
    }
}
