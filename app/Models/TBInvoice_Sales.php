<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TBInvoice_Sales extends Model
{
    protected $connection = "nyisoftechco_invoice_assessment";
    public $table = "invoice_sale";
    public $primaryKey = "id";
    protected $guarded = [];
    public $timestamps = false;
   /**
     *
     * Get using filter
     * @param array $filter
     * @param bool $single
     * @return TBSubject[]|Collection
     */
   
    public static function getWhere(array $filter,$single = false)
    {
        $criteria = 'get';
        if ($single)
            $criteria = 'first';

        if ($filter)
            return DB::connection((new self())->connection)
                ->table((new self())->table)->select('*')
                ->where($filter)->$criteria();

        return self::all();
    }

}