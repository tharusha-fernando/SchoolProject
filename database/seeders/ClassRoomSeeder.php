<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classNames = [
            'Class 1',
            'Class 2',
            'Class 3',
            'Class 4',
            'Class 5',
            'Class 6',
            'Class 7',
            'Class 8',
            'Class 9',
            'Class 10',
        ];

        
foreach ($classNames as $className) {
    // echo "Class Name: $className<br>";
    ClassRoom::factory()->create(['name'=>$className]); // Adjust the number as needed

}
        
        // ClassRoom::factory(10)->create(); // Adjust the number as needed

        //
    }
}
