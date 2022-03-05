<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class LoanApplication extends Model
{
    use SoftDeletes;

    public $table = 'loan_applications';

    public $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    const WEEKLY_LOAN = '2';



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
