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

class PaketExport implements WithEvents, WithTitle
{
    use Exportable;

    protected array $search;

    protected Collection $records;

    protected string $headerColor = '10538a';

    public function __construct(array $search, Collection $records)
    {
        $this->search   = $search;
        $this->records  = $records;
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
                $sheet->freezePane('A8');

                // set title
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'Data Paket');
                $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                // start Search
                $sheet->mergeCells('A3:B3');
                $sheet->mergeCells('A4:B4');
                $sheet->mergeCells('A5:B5');

                $sheet->setCellValue('A3', 'Tanggal Diterima Awal')
                    ->setCellValue('C3', ': ' . $this->search['tgl_awal']);

                $sheet->setCellValue('A4', 'Tanggal Diterima Akhir')
                    ->setCellValue('C4', ': ' . $this->search['tgl_akhir']);

                $sheet->setCellValue('A5', 'Kategori')
                    ->setCellValue('C5', ': ' . $this->search['kategori']);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(30);
                $sheet->getColumnDimension('G')->setWidth(30);
                $sheet->getColumnDimension('H')->setWidth(35);
                $sheet->getColumnDimension('I')->setWidth(20);

                // start Header
                $row    = 7;
                $sheet
                    ->setCellValue('A' . $row,       'No.')
                    ->setCellValue('B' . $row,       'Nama')
                    ->setCellValue('C' . $row,       'Tanggal Diterima')
                    ->setCellValue('D' . $row,       'Kategori')
                    ->setCellValue('E' . $row,       'Asrama')
                    ->setCellValue('F' . $row,       'Penerima')
                    ->setCellValue('G' . $row,       'Pengirim')
                    ->setCellValue('H' . $row,       'Isi Paket Yang Disita')
                    ->setCellValue('I' . $row,       'Status');

                $cell   = 'A' . $row . ':I' . $row;
                $sheet->getStyle($cell)->getAlignment()->setWrapText(true);
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
                $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->headerColor);
                $sheet->getStyle($cell)->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $row    = 8;
                if ($this->records->isEmpty()) {
                    $cell   = 'A' . $row;
                    $sheet->mergeCells($cell . ':I' . $row);
                    $sheet->setCellValue($cell, 'Tidak Ada Data');
                    $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    $row++;
                } else {
                    foreach ($this->records as $key => $record) {
                        $sheet
                            ->setCellValueExplicit('A' . $row, $key + 1,                        DataType::TYPE_NUMERIC)
                            ->setCellValueExplicit('B' . $row, $record->nama,                   DataType::TYPE_STRING2)
                            ->setCellValueExplicit('C' . $row, $record->tgl_diterima,           DataType::TYPE_STRING2)
                            ->setCellValueExplicit('D' . $row, $record->kategori->nama ?? '',   DataType::TYPE_STRING2)
                            ->setCellValueExplicit('E' . $row, $record->asrama->nama ?? '',     DataType::TYPE_STRING2)
                            ->setCellValueExplicit('F' . $row, $record->penerima->nama ?? '',   DataType::TYPE_STRING2)
                            ->setCellValueExplicit('G' . $row, $record->pengirim ?? '',         DataType::TYPE_STRING2)
                            ->setCellValueExplicit('H' . $row, $record->isi_yg_disita ?? '',    DataType::TYPE_STRING2)
                            ->setCellValueExplicit('I' . $row, $record->status ?? '',           DataType::TYPE_STRING2);

                        $cell   = 'A' . $row . ':I' . $row;
                        $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                        $sheet->getStyle($cell)->getAlignment()->setWrapText(true);

                        $row++;
                    }
                }
                $row--;
                $sheet->getStyle('A' . $row . ':I' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
            }
        ];
    }
}
