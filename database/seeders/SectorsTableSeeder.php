<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SectorsTableSeeder extends Seeder
{
    public array $data =
    [
        [
            'name' => 'Manufacturing', 'subcategories' => 
            [
                ['name' => 'Construction materials'],
                ['name' => 'Electronics and Optics'],
                ['name' => 'Food and Beverage', 'subcategories' => 
                    [
                        ['name' => 'Bakery & confectionery products'],
                        ['name' => 'Beverages'],
                        ['name' => 'Fish & fish products'],
                        ['name' => 'Meat & meat products'],
                        ['name' => 'Milk & dairy products'],
                        ['name' => 'Other'],
                        ['name' => 'Sweets & snack food']
                    ],
                ],
                ['name' => 'Furniture', 'subcategories' => 
                    [
                        ['name' => 'Bathroom/sauna'],
                        ['name' => 'Bedroom'],
                        ['name' => 'Children\'s room'],
                        ['name' => 'Kitchen'],
                        ['name' => 'Living room'],
                        ['name' => 'Office'],
                        ['name' => 'Other (Furniture)'],
                        ['name' => 'Outdoor'],
                        ['name' => 'Project furniture']
                    ],
                ],
                ['name' => 'Machinery', 'subcategories' => 
                    [
                        ['name' => 'Machinery components'],
                        ['name' => 'Machinery equipment/tools'],
                        ['name' => 'Manufacture of machinery'],
                        ['name' => 'Maritime', 'subcategories' => 
                            [
                                ['name' => 'Aluminium and steel workboats'],
                                ['name' => 'Boat/Yacht building'],
                                ['name' => 'Ship repair and conversion']
                            ],
                        ],
                        ['name' => 'Metal structures'],
                        ['name' => 'Other'],
                        ['name' => 'Repair and maintenance service']
                    ],
                ],
                ['name' => 'Metalworking', 'subcategories' => 
                    [
                        ['name' => 'Construction of metal structures'],
                        ['name' => 'Houses and buildings'],
                        ['name' => 'Metal products'],
                        ['name' => 'Metal works', 'subcategories' => 
                            [
                                ['name' => 'CNC-machining'],
                                ['name' => 'Forgings, Fasteners'],
                                ['name' => 'Gas, Plasma, Laser cutting'],
                                ['name' => 'MIG, TIG, Aluminum welding']
                            ],
                        ]
                    ],
                ],
                ['name' => 'Plastic and Rubber', 'subcategories' => 
                    [
                        ['name' => 'Packaging'],
                        ['name' => 'Plastic goods'],
                        ['name' => 'Plastic processing technology', 'subcategories' => 
                            [
                                ['name' => 'Blowing'],
                                ['name' => 'Moulding'],
                                ['name' => 'Plastics welding and processing']
                            ],
                        ],
                        ['name' => 'Plastic profiles']
                    ],
                ],
                ['name' => 'Printing', 'subcategories' => 
                    [
                        ['name' => 'Advertising'],
                        ['name' => 'Book/Periodicals printing'],
                        ['name' => 'Labeling and packaging printing']
                    ],
                ],
                ['name' => 'Textile and Clothing', 'subcategories' => 
                    [
                        ['name' => 'Clothing'],
                        ['name' => 'Textile']
                    ],
                ],
                ['name' => 'Wood', 'subcategories' => 
                    [
                        ['name' => 'Other (Wood)'],
                        ['name' => 'Wooden building materials'],
                        ['name' => 'Wooden houses']
                    ],
                ],
            ],
        ],
        ['name' => 'Other', 'subcategories' => 
            [
                ['name' => 'Creative industries'],
                ['name' => 'Energy technology'],
                ['name' => 'Environment']
            ],
        ],
        ['name' => 'Service', 'subcategories' => 
            [
                ['name' => 'Business services'],
                ['name' => 'Engineering'],
                ['name' => 'Information Technology and Telecommunications', 'subcategories' => 
                    [
                        ['name' => 'Data processing, Web portals, E-marketing'],
                        ['name' => 'Programming, Consultancy'],
                        ['name' => 'Software, Hardware'],
                        ['name' => 'Telecommunications']
                    ],
                ],
                ['name' => 'Tourism'],
                ['name' => 'Translation services'],
                ['name' => 'Transport and Logistics', 'subcategories' => 
                    [
                        ['name' => 'Air'],
                        ['name' => 'Rail'],
                        ['name' => 'Road'],
                        ['name' => 'Water']
                    ],
                ],
            ],
        ],
    ];

    public function run(): void
    {    
        $this->insertData(null, $this->data);
    }

    /**
     * Populate sectors table.
     */
    public function insertData(?int $parent_id, array $sectors): void
    {
        foreach($sectors as $sector){
            DB::table('sectors')->insert([
                'parent_id' => $parent_id,
                'name' => $sector['name'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            if(isset($sector['subcategories'])){
                $last_insert_id = DB::getPdo()->lastInsertId();
                $subcategories = $sector['subcategories'];
                $this->insertData($last_insert_id, $subcategories);
            }
        }
        
    }
}
