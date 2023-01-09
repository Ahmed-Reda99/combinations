<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attribute;
use App\Models\AttributeCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $category1 = AttributeCategory::create([
            'name' => 'color',
            'type' => 'color'
        ]);

        $category2 = AttributeCategory::create([
            'name' => 'size',
            'type' => 'text'
        ]);

        Attribute::create([
            'value' => '#cf1e0a',
            'attribute_category_id' => $category1->id
        ]);

        Attribute::create([
            'value' => '#fff',
            'attribute_category_id' => $category1->id
        ]);

        Attribute::create([
            'value' => '#000',
            'attribute_category_id' => $category1->id
        ]);

        Attribute::create([
            'value' => 'small',
            'attribute_category_id' => $category2->id
        ]);

        Attribute::create([
            'value' => 'medium',
            'attribute_category_id' => $category2->id
        ]);
    }
}
