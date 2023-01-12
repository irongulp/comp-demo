<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\DB;
use function view;

class QueryDemo extends Controller
{
    public function query(Property $property)
    {
        $sqlProperties = DB::select('
            SELECT  properties.id
            FROM    properties
            JOIN    certificates
            ON      certificates.property_id    = properties.id
            WHERE   properties.deleted_at       IS NULL
            AND     certificates.deleted_at     IS NULL
            GROUP
            BY      id
            HAVING  COUNT(certificates.id) > 5
        ');

        $eloquentProperties = $property
            ->withCount('certificates')
            ->having('certificates_count', '>', 5)
            ->get();

        return view('query', compact(
            'sqlProperties',
            'eloquentProperties'
        ));
    }
}
