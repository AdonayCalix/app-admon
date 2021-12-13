<?php

namespace app\modules\movement\models;

use yii\base\Model;

class VoucherFormatForm extends Model
{
    const NOT_UPLOADED_FILE = 'No Ok';
    public $excelFile;
    public $fileName;

    public function rules(): array
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    public function upload(): bool
    {
        $this->fileName = self::NOT_UPLOADED_FILE;
        $status = false;

        if ($this->validate()) {
            $this->fileName = $this->excelFile->baseName . '.' . $this->excelFile->extension;
            $this->excelFile->saveAs('excel/voucher_format/' . $this->fileName);
            $status = true;
        }

        return $status;
    }

}