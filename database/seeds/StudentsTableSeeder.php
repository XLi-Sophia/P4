<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\Grade;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed (keep stack on)
     * php artisan migrate:fresh --seed (drop all table, rebuild data using seeker)
     * @return void
     */
    public function run()
    {
        $students = [
            ['Ben', 'Affleck', 6, 1.9, 250, 'ESL', 'Wolf'],
            ['Scarlett', 'Johansson', 7, 2.4, 299, 'ENG', 'Tiger'],
            ['Sam', 'Hunt', 6, 2.3, 289, 'ENG', 'Wolf'],
            ['Tom', 'Brady', 7, 2, 150, 'ESL', 'Tiger'],
            ['Katy', 'Perry', 6, 1.5, 200, 'ESL', 'Wolf'],
            ['Robert', 'Downey', 7, 2.5, 300, 'ENG', 'Tiger'],
        ];

        $count = count($students);

        foreach ($students as $key => $studentData) {
            $student = new Student();
            /*
            $name = explode(' ', $studentData[1]);
            $lastName = array_pop($name);

            # Find that grade in the students table
            $grade_id = Grade::where('last_name', '=', $lastName)->pluck('id')->first();
            */
            $student->created_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $student->updated_at = Carbon\Carbon::now()->subDays($count)->toDateTimeString();
            $student->first_name = $studentData[0];
            $student->last_name = $studentData[1];
            /*$student->grade_id = $grade_id;*/
            $student->grade = $studentData[2];
            $student->reading_level = $studentData[3];
            $student->Fluency_level = $studentData[4];
            $student->category = $studentData[5];
            $student->team = $studentData[6];

            $student->save();
            $count--;
        }
    }
}
