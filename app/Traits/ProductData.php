<?php
// app/Traits/ProductData.php

namespace App\Traits;

trait ProductData
{
    protected function getProducts()
    {
        return [
            // HOBO BAGS
            ['id'=>101,'category'=>'hobo','name'=>'Cherry Classic Hobo','price'=>2200,'image'=>'habo bag2.jpg'],
            ['id'=>102,'category'=>'hobo','name'=>'Stow','price'=>2500,'image'=>'habo bag13.jpg'],
            ['id'=>103,'category'=>'hobo','name'=>'Moss Drop','price'=>2100,'image'=>'habo bag1.jpg'],
            ['id'=>104,'category'=>'hobo','name'=>'Ledge','price'=>2700,'image'=>'habo bag3.jpg'],
            ['id'=>105,'category'=>'hobo','name'=>'Bordeaux','price'=>2300,'image'=>'habo bag4.jpg'],
            ['id'=>106,'category'=>'hobo','name'=>'Laguna Hobo','price'=>2400,'image'=>'habo bag6.jpg'],
            ['id'=>107,'category'=>'hobo','name'=>'Cienna','price'=>2950,'image'=>'habo bag7.jpg'],
            ['id'=>108,'category'=>'hobo','name'=>'Verona','price'=>2650,'image'=>'habo bags.webp'],

            // CROSS BODY BAGS
            ['id'=>201,'category'=>'cb','name'=>'Mini Cross Body','price'=>3200,'image'=>'crossbody3.jpg'],
            ['id'=>202,'category'=>'cb','name'=>'Meridian','price'=>2500,'image'=>'cross body1.jpg'],
            ['id'=>203,'category'=>'cb','name'=>'Urban Scout','price'=>3000,'image'=>'cross body2.jpg'],
            ['id'=>204,'category'=>'cb','name'=>'Quick Draw','price'=>2700,'image'=>'crossbody4.jpg'],
            ['id'=>205,'category'=>'cb','name'=>'Commuter Compact','price'=>3600,'image'=>'crossbody5.jpg'],
            ['id'=>206,'category'=>'cb','name'=>'Traverse','price'=>2450,'image'=>'cb6.jpg'],
            ['id'=>207,'category'=>'cb','name'=>'Memento','price'=>2100,'image'=>'cb7.jpg'],
            ['id'=>208,'category'=>'cb','name'=>'The Envelope','price'=>2850,'image'=>'cb8.jpg'],

            // BACKPACKS
            ['id'=>301,'category'=>'bp','name'=>'Red Leather','price'=>3800,'image'=>'backpack3.jpg'],
            ['id'=>302,'category'=>'bp','name'=>'Metropolis','price'=>2500,'image'=>'backpack1.jpg'],
            ['id'=>303,'category'=>'bp','name'=>'The Slug','price'=>3500,'image'=>'bp11.jpg'],
            ['id'=>304,'category'=>'bp','name'=>'Zephyr','price'=>4800,'image'=>'backpacks.jpg'],
            ['id'=>305,'category'=>'bp','name'=>'Stride','price'=>2700,'image'=>'bp4.jpg'],
            ['id'=>306,'category'=>'bp','name'=>'Summit','price'=>3800,'image'=>'bp5.jpg'],
            ['id'=>307,'category'=>'bp','name'=>'Wayfarer','price'=>2750,'image'=>'bp6.jpg'],
            ['id'=>308,'category'=>'bp','name'=>'Canvas Cube','price'=>4000,'image'=>'bp7.jpg'],

            // TOTE BAGS
            ['id'=>401,'category'=>'tote','name'=>'Everyday Tote','price'=>3000,'image'=>'totebag7.jpg'],
            ['id'=>402,'category'=>'tote','name'=>'Leather Commuter','price'=>2300,'image'=>'tote bag.jpg'],
            ['id'=>403,'category'=>'tote','name'=>'Laptop Work Tote','price'=>2900,'image'=>'totebag5.jpg'],
            ['id'=>404,'category'=>'tote','name'=>'Mesh Beachcomber Tote','price'=>2450,'image'=>'totebag6.jpg'],
            ['id'=>405,'category'=>'tote','name'=>'Vanilla Voyager','price'=>2700,'image'=>'totebag8.jpg'],
            ['id'=>406,'category'=>'tote','name'=>'Mini Tote','price'=>3200,'image'=>'tote bag9.jpg'],
            ['id'=>407,'category'=>'tote','name'=>'Structured Bucket Tote','price'=>3250,'image'=>'tote bag10.jpg'],
            ['id'=>408,'category'=>'tote','name'=>'Eco-Jute Market Tote','price'=>3600,'image'=>'totebag12.jpg'],
        ];
    }
}
