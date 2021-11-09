<?php

namespace app\modules\qb\models;

use yii\base\Model;
use function Symfony\Component\String\s;

class ImportForm extends Model
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
            $this->excelFile->saveAs('uploads/' . $this->fileName);
            $status = true;
        }

        return $status;
    }
}