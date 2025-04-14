<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cel;

class CelSeeder extends Seeder
{
    public function run()
    {
        $cellen = [
            'A100', 'A101', 'A102', 'A103', 'A104', 'A105', 'A106', 'A107', 'A108', 'A109', 'A110', 'A111', 'A112',
            'B200', 'B201', 'B202', 'B203', 'B204', 'B205', 'B206', 'B207', 'B208', 'B209', 'B210', 'B211', 'B212', 'B213', 'B214', 'B215',
            'C336', 'C337', 'C338', 'C339', 'C340', 'C341', 'C342', 'C343', 'C344', 'C345', 'C346', 'C347', 'C348', 'C349', 'C350', 'C351', 'C352', 'C353', 'C354', 'C355', 'C356', 'C357', 'C358', 'C359', 'C360', 'C361', 'C362', 'C363', 'C364'
        ];

        foreach ($cellen as $cel) {
            Cel::create([
                'naam' => $cel,
            ]);
        }
    }
}
