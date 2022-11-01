<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public function getFileWithoutTimestamp(){
        return substr($this->file, strpos($this->file, "_") + 1);
    }
}
