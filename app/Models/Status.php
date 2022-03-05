<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Status extends Model
{
    use SoftDeletes;

    public $table = 'statuses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const NEW_STATUS = '1';
    const APPROVED_STATUS = '3';
    const PROCESSING_STATUS = '2';
    const REJECTED_STATUS = '4';
    const COMPLETED_STATUS = '5';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
