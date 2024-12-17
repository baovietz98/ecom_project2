<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return Product::all();
        
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'price',
            'created_at',
            'updated_at',
        ];
    }
}
