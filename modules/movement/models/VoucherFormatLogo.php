<?php

namespace app\modules\movement\models;

use yii\base\Model;

class VoucherFormatLogo extends Model
{
    const NOT_UPLOADED_FILE = 'No Ok';
    public $excelFile;
    public $fileName;
    public $originalName;
    public $path;

    public function rules(): array
    {
        return [
            [['logoFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png'],
        ];
    }

    public function upload(): bool
    {
        $this->fileName = self::NOT_UPLOADED_FILE;
        $status = false;

        if ($this->validate()) {
            $this->originalName = $this->excelFile->baseName;
            $this->fileName = time().uniqid(rand()) . '.' . $this->excelFile->extension;
            $this->path = 'excel/voucher_format/' . $this->fileName;
            $this->excelFile->saveAs($this->path);
            $status = true;
        }

        return $status;
    }

}