<?php

namespace app\components;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ExcelExport
{
    const FIRST_INDEX = 0;

    const COLOR_HEADER = '002060';

    const COLOR_HEADER_FONT = 'FFFFFFFF';

    /**
     * @param string $path
     * @return Spreadsheet
     */
    public function initExcel(string $path): Spreadsheet
    {
        return IOFactory::load(Yii::$app->basePath . $path);
    }

    /**
     * @param Spreadsheet $objectoExcel
     * @param string $coordenada
     * @param int $height
     * @param string $path
     */
    public function setLogo(Spreadsheet $objectoExcel, string $coordenada, int $height, string $path): void
    {
        $drawing = new Drawing();
        $drawing->setName('LOGO');
        $drawing->setDescription('LOGO');

        try {
            $drawing->setPath(Yii::$app->basePath . "/web/{$path}");
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $drawing->setCoordinates($coordenada);
        $drawing->setHeight($height);

        try {
            $drawing->setWorksheet($objectoExcel->getActiveSheet());
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param Worksheet $sheetExcel
     * @param int $row
     * @param string $coordinate
     * @param array $source
     */
    public function setDateFormatToColum(Worksheet $sheetExcel, int $row, string $coordinate, array $source): void
    {
        foreach ($source as $item) {
            if ($item !== null)
                $sheetExcel->setCellValue(("{$coordinate}" . $row), Date::PHPToExcel($item));
            $row++;
        }
    }

    /**
     * @param Worksheet $sheetExcel
     * @param int $row
     * @param string $title
     * @param array $source
     */
    public function setHeaderTable(Worksheet $sheetExcel, int $row, string $title, array $source): void
    {
        $fisrt_index = self::FIRST_INDEX;
        $last_index = count($source) - 1;

        $coordinate_first = $this->getLetterColum($fisrt_index) . $row;
        $coordinate_last = $this->getLetterColum($last_index) . $row;

        try {
            $sheetExcel->mergeCells("{$coordinate_first}:{$coordinate_last}");
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $sheetExcel->setCellValue("{$coordinate_first}", strtoupper($title));

        $sheetExcel->getStyle("{$coordinate_first}")->getFont()
            ->getColor()
            ->setARGB(self::COLOR_HEADER_FONT);

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFont()->setBold(true);

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getAlignment()->setHorizontal('center');

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB(self::COLOR_HEADER);
    }

    /**
     * @param Worksheet $sheetExcel
     * @param array $config
     */
    public function setHeaderHorizontalTable(Worksheet $sheetExcel, array $config = []): void
    {

        $last_index = ($config['first_index'] ?? 0) + (int)$config['size'] ?? 0;

        $coordinate_first = $this->getLetterColum(($config['first_index'] ?? 0), "ZZ") . $config['row'] ?? 0;
        $coordinate_last = $this->getLetterColum($last_index, "ZZ") . $config['row'] ?? 0;

        try {
            $sheetExcel->mergeCells("{$coordinate_first}:{$coordinate_last}");
            $this->setStyleByCell($sheetExcel, "{$coordinate_first}:{$coordinate_last}", $config['styleCell'] ?? []);
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $sheetExcel->setCellValue("{$coordinate_first}", $config['title'] ?? null);

        $sheetExcel->getStyle("{$coordinate_first}")->getFont()
            ->getColor()
            ->setARGB('FF000000');

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFont()->setBold(true);

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getAlignment()->setHorizontal($config["aligment_horizontal"] ?? 'center');

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($config['color'] ?? 'FFFFFFFF');
    }

    /**
     * @param Worksheet $sheetExcel
     * @param string $coordinate_first
     * @param string $coordinate_last
     * @param string $title
     */
    public function setHeaderVerticalTable(Worksheet $sheetExcel, string $coordinate_first, string $coordinate_last, string $title): void
    {
        try {
            $sheetExcel->mergeCells("{$coordinate_first}:{$coordinate_last}");
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $sheetExcel->setCellValue("{$coordinate_first}", $title);

        $sheetExcel->getStyle("{$coordinate_first}")->getFont()
            ->getColor()
            ->setARGB('FF000000');

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFont()->setBold(true);

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getAlignment()->setHorizontal('center');

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFFFFFFF');
    }

    /**
     * @param Worksheet $sheetExcel
     * @param int $row
     * @param array $source
     */
    public function setColumnNameTable(Worksheet $sheetExcel, int $row, array $source): void
    {
        $fisrt_index = self::FIRST_INDEX;
        $last_index = count($source) - 1;

        $coordinate_first = $this->getLetterColum($fisrt_index) . $row;
        $coordinate_last = $this->getLetterColum($last_index) . $row;

        $sheetExcel->fromArray($source, null, "A{$row}");

        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")
            ->getFont()
            ->setBold(true);
    }

    /**
     * @param Worksheet $sheetExel
     * @param string $coordinate
     * @param array $source
     */
    public function setContentTable(Worksheet $sheetExel, string $coordinate, array $source): void
    {
        $sheetExel->fromArray($source, false, $coordinate, true);
    }

    /**
     * @param Worksheet $sheetExcel
     * @param int $row
     * @param array $source
     */
    public function setFooterTable(Worksheet $sheetExcel, int $row, array $source): void
    {
        $fisrt_index = 0;
        $last_index = count($source) - 1;

        $coordinate_first = $this->getLetterColum($fisrt_index) . $row;
        $coordinate_last = $this->getLetterColum($last_index) . $row;

        $sheetExcel->fromArray($source, null, "A{$row}", true);
        $sheetExcel->getStyle("{$coordinate_first}:{$coordinate_last}")->getFont()->setBold(true);
    }

    /**
     * @param Worksheet $sheetExcel
     * @param string $coordinate
     * @param string $value
     */
    public function setValueInCell(Worksheet $sheetExcel, string $coordinate, string $value): void
    {
        $sheetExcel->setCellValue("{$coordinate}", $value);
    }

    /**
     * @param Spreadsheet $excelObject
     * @param string $path
     */
    public function downloadExcel(Spreadsheet $excelObject, string $path): void
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename= "' . $path . '"');
        header('Cache-Control: max-age=0');

        try {
            $writer = IOFactory::createWriter($excelObject, 'Xlsx');
            $writer->save('php://output');
            exit();
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param int $index
     * @param string $columns_range
     * @return string
     */
    public function getLetterColum(int $index, string $columns_range = "AZ"): string
    {
        $columns = $columns_range === "AZ" ? range('A', 'Z') : $this->createColumnsArray($columns_range);

        return $columns[$index];
    }

    /**
     * @param $end_column
     * @param string $first_letters
     * @return array
     */
    public function createColumnsArray($end_column, $first_letters = ""): array
    {
        $columns = [];
        $length = strlen($end_column);
        $letters = range('A', 'Z');

        foreach ($letters as $letter) {
            $column = $first_letters . $letter;
            $columns[] = $column;
            if ($column == $end_column)
                return $columns;
        }

        foreach ($columns as $column) {
            if (!in_array($end_column, $columns) && strlen($column) < $length) {
                $new_columns = $this->createColumnsArray($end_column, $column);
                $columns = array_merge($columns, $new_columns);
            }
        }

        return $columns;
    }

    /**
     * @param Worksheet $sheetExcel
     * @param int $row
     * @param int $height
     */
    public function setHeightRow(Worksheet $sheetExcel, int $row, int $height): void
    {
        $sheetExcel->getRowDimension($row)->setRowHeight($height);
    }

    /**
     * @param Worksheet $sheetExcel
     * @param string $column
     * @param int $width
     */
    public function setWidthColum(Worksheet $sheetExcel, string $column, int $width): void
    {
        $obj = $sheetExcel->getColumnDimension($column);

        if ($width === 0) {
            $obj->setAutoSize(true);
        } else {
            $obj->setWidth($width);
        }
    }

    /**
     * @param Worksheet $sheetExcel
     * @param string $coordinate
     * @param array $config
     */
    public function setStyleByCell(Worksheet $sheetExcel, string $coordinate, array $config = []): void
    {
        $styleArray = [
            'font' => [
                'bold' => $config["bold"] ?? false,
                'italic' => $config["italic"] ?? false,
                'size' => $config["size"] ?? 11
            ],
            'alignment' => [
                'horizontal' => $config["alignment_horizontal"] ?? "center",
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ]
        ];

        $sheetExcel->getStyle($coordinate)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);

        $sheetExcel->getStyle("{$coordinate}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($config['color'] ?? "FFFFFF");
    }
}