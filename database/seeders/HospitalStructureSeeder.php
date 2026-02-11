<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Department;

class HospitalStructureSeeder extends Seeder
{
    public function run(): void
    {
        $structure = [

            'Medical Service' => [
                'Admitting / Information',
                'Anatomic and Clinical Laboratory',
                'Blood Bank',
                'Clinical Departments',
                'Dental Services',
                'Department of Pathology',
                'Department of Radiology',
                'Emergency Medicine Department',
                'Health Information',
                'Human Milk Bank',
                'Medical Social Work',
                'Nutrition and Dietetics',
                'Out-Patient Unit',
                'Pharmacy',
                'Special Care Areas',
            ],

            'Office of the Administrative Officer' => [
                'Accounting',
                'Billing and Claims',
                'Budget',
                'Cash Operations',
                'Engineering and Facilities Management',
                'Housekeeping / Laundry',
                'Human Resource Management',
                'Materials Management',
                'Procurement',
            ],

            'Office of the Chief Nurse' => [
                'Central Supply and Sterilization',
                'Clinical Nursing Units',
                'Delivery Room',
                'Intensive Care Unit',
                'Neonatal Intensive Care Unit',
                'Operating Room',
                'Pulmonary / Respiratory Unit',
                'Special Care Areas',
                'Post Anesthesia Care Unit',
            ],

            'Office of the Chief of Hospital' => [
                'Office of the Chief of Hospital',
            ],
        ];

        foreach ($structure as $divisionName => $departments) {

            $division = Division::firstOrCreate([
                'name' => $divisionName
            ]);

            foreach ($departments as $deptName) {

                Department::firstOrCreate([
                    'division_id' => $division->id,
                    'name' => $deptName
                ]);
            }
        }
    }
}
