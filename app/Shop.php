<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    protected $table = 'shop';
    protected $fillable = ['shopname','doorno','username','phone','is_delete'];
    public $timestamps = TRUE;

    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }


}