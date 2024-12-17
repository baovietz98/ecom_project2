<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Product;

class ProductImport implements  ToModel , WithHeadingRow , WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Product([
            'category_id' => $row['category_id'],
            'title' => $row['title'],
            'price' => $row['price'],
            'thumbnail' => 'products/' . $row['thumbnail'],  // Đường dẫn ảnh tương đối từ thư mục public
            'description' => $row['description'],  
            'quantity' => $row['quantity'],
            'brand_id' => $row['brand_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'title' => 'required',
            'price' => 'required',
            'thubnail' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'brand_id' => 'required',
        ];
    }
}
