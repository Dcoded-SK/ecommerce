<?php

namespace App\Imports;

use App\Models\Genre;
use Maatwebsite\Excel\Concerns\ToModel;

class GenreImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Genre([
            //

            'name' => $row[0]
        ]);
    }

    public function rules()
    {
        return ['name' => 'unique:genres,name'];
    }
}
