<?php

namespace App\Imports;
// use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Employe;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // echo $row[5];
        $nom = $row[1];
        return new Employe([
            'nom'     => $nom,
            'prenom'    => $row[2],
            'matricule' => $row[0],
            'cardNo' => intval($row[4]),
            'departement_id' => intval($row[5]),
            'avatar_id' => 1
            // 'password' => Hash::make($row[2])
        ]);
    }
}