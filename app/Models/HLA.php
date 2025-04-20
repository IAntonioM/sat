<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HlaModel extends Model
{
    protected $table = 'HLP_PORTAL'; // We'll use raw queries with the stored procedure

    /**
     * Get contributor data
     *
     * @param string $vcodcontr
     * @return object
     */
    public static function getContributorData($vcodcontr)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='1', @vcodcontr=?", [$vcodcontr])[0] ?? null;
    }

    /**
     * Get HLA detail data
     *
     * @param string $vcodcontr
     * @param string $year
     * @return array
     */
    public static function getHlaDetail($vcodcontr, $year)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='7', @vcodcontr=?, @paramt5=?", [$vcodcontr, $year]);
    }

    /**
     * Get HLA summary data
     *
     * @param string $vcodcontr
     * @param string $year
     * @return object
     */
    public static function getHlaSummary($vcodcontr, $year)
    {
        $result = DB::select("exec pxConsultasWeb2 @msquery='7', @vcodcontr=?, @paramt5=?", [$vcodcontr, $year]);

        // Calculate totals from the result
        $summary = [
            'sum_limpub' => 0,
            'sum_resiso' => 0,
            'sum_parjar' => 0,
            'sum_serena' => 0,
            'total' => 0
        ];

        foreach ($result as $row) {
            $summary['sum_limpub'] += $row->limpub ?? 0;
            $summary['sum_resiso'] += $row->resiso ?? 0;
            $summary['sum_parjar'] += $row->parjar ?? 0;
            $summary['sum_serena'] += $row->serena ?? 0;
            $summary['total'] += $row->total ?? 0;
        }

        return (object)$summary;
    }

    /**
     * Get HLP (Property tax) data
     *
     * @param string $vcodcontr
     * @param string $year
     * @return object
     */
    public static function getHlpData($vcodcontr, $year)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='6', @vcodcontr=?, @paramt5=?", [$vcodcontr, $year])[0] ?? null;
    }
}
