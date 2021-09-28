<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ClientsImport implements ToCollection, WithStartRow
{
    public $person;
    public $person_id;

    public function currentPerson($phone)
    {
        //test if person exists in people table
        return Person::where('phone1', $phone)
            ->orWhere('phone2', $phone)
            ->first();

    }

    public function isExist($person_id)
    {
        //test if exists in clients table
        $provider = Client::where('person_id', $person_id)->first();
        if (!empty($provider)) {
            return true;
        } else {
            return false;
        }
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $qryPhone1 = $this->currentPerson($row[4]);
            $qryPhone2 = $this->currentPerson($row[5]);

            if (empty($qryPhone1) and empty($qryPhone2)) {
                /* Person NOT EXIST */
                $this->person = Person::create([
                    'last_name' => $row[0],
                    'first_name' => $row[1],
                    'father_name' => $row[2],
                    'address' => $row[3],
                    'phone1' => $row[4],
                    'phone2' => $row[5]
                ]);

                Client::create([
                    'person_id' => $this->person->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            } else {
                /* Person EXIST */
                //Get the person id
                if (!empty($qryPhone1)) {
                    $this->person_id = $qryPhone1->id;

                } elseif (!empty($qryPhone2)) {
                    $this->person_id = $qryPhone2->id;
                }
                //Add person to clients table if not exist
                if ($this->isExist($this->person_id) == false) {
                    Client::create([
                        'person_id' => $this->person_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
