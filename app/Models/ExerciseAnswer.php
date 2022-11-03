<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseAnswer extends Model
{
    public function getFileWithoutTimestamp(){
        return substr($this->answer_file, strpos($this->answer_file, "_") + 1);
    }
}
