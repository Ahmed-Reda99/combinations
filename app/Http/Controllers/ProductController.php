<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\Combination;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function create()
    {
        $attributeCategories = AttributeCategory::with('attributes')->get();
        $attributes = Attribute::with('category:id,type')->get();

        return view('create-product', compact('attributes','attributeCategories'));
    }


    public function store(Request $request)
    {
        if($request->hasFile('main_image'))
        {
            $originalName =  $request->file('main_image')->getClientOriginalName();
            $imageName    = str_replace(' ','_','_' . time() . $originalName);
            $request->file('main_image')->storeAs('/Images', $imageName,'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'main_image' => $imageName
        ]);

        foreach ($request->combinations as $index => $combination) {
            $combinationImages = [];
            foreach ($combination['images'] as $index => $image) {
                $originalName =  $image->getClientOriginalName();
                $imageName    = str_replace(' ','_',time() . $originalName);
                $image->storeAs('/Images', $imageName,'public');
                $combinationImages[$index] = $imageName;
            }

            $createdCombination = Combination::create([
                'price' => $combination['price'],
                'images' => serialize($combinationImages),
                'stock_quantity' => $combination['stock_quantity'],
                'product_id' => $product->id,
            ]);

            foreach (explode('-',$combination['identifier']) as $value) {
                $createdCombination->attributes()->attach($value);
            }
        }

        return 'saved successfully';
    }

    public function getCombinations(Request $request)
    {

        $combinations = [[]];

        foreach($request['selectedAttributes'] as $categoryId => $attributes)
        {
            // assign category_id to product if needed
            $tmp = $combinations;
            $combinations = [];
    
            foreach($tmp as $combination)
            {
                foreach($attributes as $attributeId) {
                    $combinations[] = array_merge($combination,[$attributeId]);
                }
            }
    
        }
    
        return $combinations;
    }

}
