<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    const FILE_DIR = 'private/quizzes/';

    public function getFileName($onlyFileName = false){
        $fileName = substr($this->file, strpos($this->file, "_") + 1);
        if($onlyFileName){
            $fileName = pathinfo($fileName)['filename']; 
        }
        return $fileName;
    }

    public function getFilePath(){
        return self::FILE_DIR.$this->file;
    }
    
}
