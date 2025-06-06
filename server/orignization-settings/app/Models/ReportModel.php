<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    use HasFactory;
    protected $table = 'reports';

    public function positions()
    {
        return $this->hasMany(PositionModel::class);
    }
    
}
