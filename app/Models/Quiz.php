<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    public function getAnswer(){
        $fileWihoutTimestamp =  substr($this->file, strpos($this->file, "_") + 1);
        
    }
}
