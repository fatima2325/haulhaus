<?php

namespace App\Traits;

trait ProductData
{
    public function getProducts()
    {
        return [
            // ================= HOBO BAGS =================
            [
                'id'=>101,
                'category'=>'hobo',
                'name'=>'Cherry Classic Hobo',
                'price'=>2200,
                'image'=>'habo bag2.jpg',
                'description'=>'A timeless hobo bag in rich cherry leather with a soft silhouette and roomy interior for daily essentials.',
                'reviews'=>[
                    ['name'=>'Areeba Z.','rating'=>5,'comment'=>'Love the color and quality! Perfect for work.'],
                    ['name'=>'Maham S.','rating'=>4,'comment'=>'Spacious and classy, goes with any outfit.']
                ]
            ],
            [
                'id'=>102,
                'category'=>'hobo',
                'name'=>'Stow',
                'price'=>2500,
                'image'=>'habo bag13.jpg',
                'description'=>'Elegant and minimal, the Stow hobo bag offers comfort and a touch of sophistication.',
                'reviews'=>[
                    ['name'=>'Noor F.','rating'=>5,'comment'=>'Lightweight and stylish. My go-to bag!'],
                    ['name'=>'Ayesha M.','rating'=>4,'comment'=>'Quality leather, very durable.']
                ]
            ],
            [
                'id'=>103,
                'category'=>'hobo',
                'name'=>'Moss Drop',
                'price'=>2100,
                'image'=>'habo bag1.jpg',
                'description'=>'Inspired by nature, Moss Drop features a soft green tone and smooth curve design for an earthy vibe.',
                'reviews'=>[
                    ['name'=>'Anum L.','rating'=>5,'comment'=>'The color is beautiful! Looks so unique.'],
                    ['name'=>'Iqra J.','rating'=>4,'comment'=>'Very comfortable shoulder fit.']
                ]
            ],
            [
                'id'=>104,
                'category'=>'hobo',
                'name'=>'Ledge',
                'price'=>2700,
                'image'=>'habo bag3.jpg',
                'description'=>'A structured hobo bag that balances modern style with everyday function.',
                'reviews'=>[
                    ['name'=>'Maryam A.','rating'=>5,'comment'=>'So chic and premium. Worth every penny!'],
                    ['name'=>'Hina K.','rating'=>4,'comment'=>'Solid build, fits everything I need.']
                ]
            ],
            [
                'id'=>105,
                'category'=>'hobo',
                'name'=>'Bordeaux',
                'price'=>2300,
                'image'=>'habo bag4.jpg',
                'description'=>'A rich burgundy hobo crafted from soft faux leather — elegant and bold for any season.',
                'reviews'=>[
                    ['name'=>'Fatima R.','rating'=>5,'comment'=>'Such a gorgeous color, I get compliments every day!'],
                    ['name'=>'Sana P.','rating'=>4,'comment'=>'Beautiful and practical.']
                ]
            ],
            [
                'id'=>106,
                'category'=>'hobo',
                'name'=>'Laguna Hobo',
                'price'=>2400,
                'image'=>'habo bag6.jpg',
                'description'=>'Coastal-inspired soft blue tones with a boho silhouette and roomy compartments.',
                'reviews'=>[
                    ['name'=>'Emaan F.','rating'=>5,'comment'=>'Perfect vacation bag! Love it.'],
                    ['name'=>'Laiba N.','rating'=>4,'comment'=>'Color is stunning and fits so much.']
                ]
            ],
            [
                'id'=>107,
                'category'=>'hobo',
                'name'=>'Cienna',
                'price'=>2950,
                'image'=>'habo bag7.jpg',
                'description'=>'Refined simplicity in a lightweight hobo that blends modern and classic design.',
                'reviews'=>[
                    ['name'=>'Hafsa K.','rating'=>5,'comment'=>'So elegant. Matches everything!'],
                    ['name'=>'Zoya M.','rating'=>4,'comment'=>'Love the shape and material.']
                ]
            ],
            [
                'id'=>108,
                'category'=>'hobo',
                'name'=>'Verona',
                'price'=>2650,
                'image'=>'habo bags.webp',
                'description'=>'A modern classic hobo featuring soft curves and gold detailing for subtle luxury.',
                'reviews'=>[
                    ['name'=>'Mina T.','rating'=>5,'comment'=>'Looks designer-level! Great quality.'],
                    ['name'=>'Sahar B.','rating'=>4,'comment'=>'Stylish and elegant, very versatile.']
                ]
            ],

            // ================= CROSSBODY BAGS =================
            [
                'id'=>201,
                'category'=>'cb',
                'name'=>'Mini Cross Body',
                'price'=>3200,
                'image'=>'crossbody3.jpg',
                'description'=>'Compact, trendy, and lightweight — ideal for on-the-go comfort with everyday outfits.',
                'reviews'=>[
                    ['name'=>'Ayesha K.','rating'=>5,'comment'=>'Adorable size! Perfect for daily use.'],
                    ['name'=>'Sara M.','rating'=>4,'comment'=>'Great stitching and finish.']
                ]
            ],
            [
                'id'=>202,
                'category'=>'cb',
                'name'=>'Meridian',
                'price'=>2500,
                'image'=>'cross body1.jpg',
                'description'=>'Sleek crossbody design for effortless travel and daily wear with adjustable strap.',
                'reviews'=>[
                    ['name'=>'Nimra S.','rating'=>5,'comment'=>'Super comfortable to wear!'],
                    ['name'=>'Hira A.','rating'=>4,'comment'=>'Spacious enough for essentials.']
                ]
            ],
            [
                'id'=>203,
                'category'=>'cb',
                'name'=>'Urban Scout',
                'price'=>3000,
                'image'=>'cross body2.jpg',
                'description'=>'A rugged and functional crossbody built for adventures and city life.',
                'reviews'=>[
                    ['name'=>'Tania M.','rating'=>5,'comment'=>'Exactly what I needed for travel!'],
                    ['name'=>'Maryam B.','rating'=>4,'comment'=>'Good size, durable zippers.']
                ]
            ],
            [
                'id'=>204,
                'category'=>'cb',
                'name'=>'Quick Draw',
                'price'=>2700,
                'image'=>'crossbody4.jpg',
                'description'=>'Sporty yet stylish, the Quick Draw bag offers hands-free convenience with flair.',
                'reviews'=>[
                    ['name'=>'Anaya J.','rating'=>5,'comment'=>'Trendy and easy to carry.'],
                    ['name'=>'Khadija F.','rating'=>4,'comment'=>'Perfect for casual wear.']
                ]
            ],
            [
                'id'=>205,
                'category'=>'cb',
                'name'=>'Commuter Compact',
                'price'=>3600,
                'image'=>'crossbody5.jpg',
                'description'=>'Designed for the modern commuter — lightweight yet surprisingly spacious.',
                'reviews'=>[
                    ['name'=>'Esha L.','rating'=>5,'comment'=>'Love the sleek design and compartments.'],
                    ['name'=>'Sadaf R.','rating'=>4,'comment'=>'Comfortable strap, great for work.']
                ]
            ],
            [
                'id'=>206,
                'category'=>'cb',
                'name'=>'Traverse',
                'price'=>2450,
                'image'=>'cb6.jpg',
                'description'=>'A simple and sturdy design with easy front pockets for quick access.',
                'reviews'=>[
                    ['name'=>'Mehwish G.','rating'=>5,'comment'=>'Minimal and beautiful!'],
                    ['name'=>'Aimen N.','rating'=>4,'comment'=>'Great everyday bag.']
                ]
            ],
            [
                'id'=>207,
                'category'=>'cb',
                'name'=>'Memento',
                'price'=>2100,
                'image'=>'cb7.jpg',
                'description'=>'A vintage-inspired crossbody that pairs well with classic or casual looks.',
                'reviews'=>[
                    ['name'=>'Alisha S.','rating'=>5,'comment'=>'Retro and stylish!'],
                    ['name'=>'Shiza K.','rating'=>4,'comment'=>'Small but fits essentials nicely.']
                ]
            ],
            [
                'id'=>208,
                'category'=>'cb',
                'name'=>'The Envelope',
                'price'=>2850,
                'image'=>'cb8.jpg',
                'description'=>'Slim and elegant with a magnetic flap — ideal for events or date nights.',
                'reviews'=>[
                    ['name'=>'Iqra Z.','rating'=>5,'comment'=>'Looks very high-end!'],
                    ['name'=>'Saniya A.','rating'=>4,'comment'=>'Chic and modern design.']
                ]
            ],

            // ================= BACKPACKS =================
            [
                'id'=>301,
                'category'=>'bp',
                'name'=>'Red Leather',
                'price'=>3800,
                'image'=>'backpack3.jpg',
                'description'=>'Bold red leather backpack with premium finish and multiple compartments.',
                'reviews'=>[
                    ['name'=>'Maha T.','rating'=>5,'comment'=>'Strong, stylish, and eye-catching!'],
                    ['name'=>'Areej P.','rating'=>4,'comment'=>'Good quality and comfortable straps.']
                ]
            ],
            [
                'id'=>302,
                'category'=>'bp',
                'name'=>'Metropolis',
                'price'=>2500,
                'image'=>'backpack1.jpg',
                'description'=>'Urban-style backpack perfect for daily commute and laptops.',
                'reviews'=>[
                    ['name'=>'Bushra L.','rating'=>5,'comment'=>'Exactly what I wanted for work!'],
                    ['name'=>'Naila I.','rating'=>4,'comment'=>'Nice compartments, good for travel.']
                ]
            ],
            [
                'id'=>303,
                'category'=>'bp',
                'name'=>'The Slug',
                'price'=>3500,
                'image'=>'bp11.jpg',
                'description'=>'Soft and sturdy, The Slug is your go-to casual backpack for every occasion.',
                'reviews'=>[
                    ['name'=>'Huma Z.','rating'=>5,'comment'=>'Lightweight and super comfortable!'],
                    ['name'=>'Iram F.','rating'=>4,'comment'=>'Stylish yet functional.']
                ]
            ],
            [
                'id'=>304,
                'category'=>'bp',
                'name'=>'Zephyr',
                'price'=>4800,
                'image'=>'backpacks.jpg',
                'description'=>'Sleek black backpack with laptop sleeve and ergonomic straps.',
                'reviews'=>[
                    ['name'=>'Aqsa K.','rating'=>5,'comment'=>'Luxury feel, love the look.'],
                    ['name'=>'Lubna N.','rating'=>4,'comment'=>'Spacious and strong material.']
                ]
            ],
            [
                'id'=>305,
                'category'=>'bp',
                'name'=>'Stride',
                'price'=>2700,
                'image'=>'bp4.jpg',
                'description'=>'Designed for travelers — stylish, compact, and practical.',
                'reviews'=>[
                    ['name'=>'Warda B.','rating'=>5,'comment'=>'Amazing quality!'],
                    ['name'=>'Mina J.','rating'=>4,'comment'=>'Love it for everyday use.']
                ]
            ],
            [
                'id'=>306,
                'category'=>'bp',
                'name'=>'Summit',
                'price'=>3800,
                'image'=>'bp5.jpg',
                'description'=>'Adventure-ready backpack with premium zippers and rugged texture.',
                'reviews'=>[
                    ['name'=>'Hania R.','rating'=>5,'comment'=>'Durable and looks amazing!'],
                    ['name'=>'Farah T.','rating'=>4,'comment'=>'Spacious and waterproof.']
                ]
            ],
            [
                'id'=>307,
                'category'=>'bp',
                'name'=>'Wayfarer',
                'price'=>2750,
                'image'=>'bp6.jpg',
                'description'=>'Stylish and durable backpack made for wanderers and students alike.',
                'reviews'=>[
                    ['name'=>'Nimra J.','rating'=>5,'comment'=>'Perfect for college!'],
                    ['name'=>'Nazia K.','rating'=>4,'comment'=>'Comfortable straps and nice design.']
                ]
            ],
            [
                'id'=>308,
                'category'=>'bp',
                'name'=>'Canvas Cube',
                'price'=>4000,
                'image'=>'bp7.jpg',
                'description'=>'Minimalist canvas design with large inner storage and side pockets.',
                'reviews'=>[
                    ['name'=>'Alina F.','rating'=>5,'comment'=>'Super aesthetic and eco-friendly.'],
                    ['name'=>'Safa M.','rating'=>4,'comment'=>'Great texture and material.']
                ]
            ],

            // ================= TOTE BAGS =================
            [
                'id'=>401,
                'category'=>'tote',
                'name'=>'Everyday Tote',
                'price'=>3000,
                'image'=>'totebag7.jpg',
                'description'=>'Classic tote bag for everyday errands and office use.',
                'reviews'=>[
                    ['name'=>'Mehak R.','rating'=>5,'comment'=>'Strong and stylish!'],
                    ['name'=>'Hira P.','rating'=>4,'comment'=>'Nice handles and color.']
                ]
            ],
            [
                'id'=>402,
                'category'=>'tote',
                'name'=>'Leather Commuter',
                'price'=>2300,
                'image'=>'tote bag.jpg',
                'description'=>'Soft leather tote that combines sophistication with practicality.',
                'reviews'=>[
                    ['name'=>'Asma F.','rating'=>5,'comment'=>'My favorite work bag!'],
                    ['name'=>'Zainab L.','rating'=>4,'comment'=>'Looks elegant and minimal.']
                ]
            ],
            [
                'id'=>403,
                'category'=>'tote',
                'name'=>'Laptop Work Tote',
                'price'=>2900,
                'image'=>'totebag5.jpg',
                'description'=>'Smart tote bag designed to carry your laptop and essentials in style.',
                'reviews'=>[
                    ['name'=>'Areeba K.','rating'=>5,'comment'=>'Fits my 15-inch laptop perfectly.'],
                    ['name'=>'Sobia A.','rating'=>4,'comment'=>'Chic and useful.']
                ]
            ],
            [
                'id'=>404,
                'category'=>'tote',
                'name'=>'Mesh Beachcomber Tote',
                'price'=>2450,
                'image'=>'totebag6.jpg',
                'description'=>'Light mesh tote for beach trips and casual outings.',
                'reviews'=>[
                    ['name'=>'Laiba F.','rating'=>5,'comment'=>'Perfect for beach days!'],
                    ['name'=>'Aimen Q.','rating'=>4,'comment'=>'Light and easy to clean.']
                ]
            ],
            [
                'id'=>405,
                'category'=>'tote',
                'name'=>'Vanilla Voyager',
                'price'=>2700,
                'image'=>'totebag8.jpg',
                'description'=>'Elegant cream-colored tote with gold-toned accents and roomy design.',
                'reviews'=>[
                    ['name'=>'Hafsa T.','rating'=>5,'comment'=>'So classy!'],
                    ['name'=>'Sadia W.','rating'=>4,'comment'=>'Great for everyday use.']
                ]
            ],
            [
                'id'=>406,
                'category'=>'tote',
                'name'=>'Mini Tote',
                'price'=>3200,
                'image'=>'tote bag9.jpg',
                'description'=>'A smaller tote for a minimalist look and easy carry.',
                'reviews'=>[
                    ['name'=>'Kiran R.','rating'=>5,'comment'=>'Cute and practical!'],
                    ['name'=>'Tania L.','rating'=>4,'comment'=>'Ideal size for essentials.']
                ]
            ],
            [
                'id'=>407,
                'category'=>'tote',
                'name'=>'Structured Bucket Tote',
                'price'=>3250,
                'image'=>'tote bag10.jpg',
                'description'=>'Sculpted tote that blends elegance with structure and detail.',
                'reviews'=>[
                    ['name'=>'Maliha G.','rating'=>5,'comment'=>'Looks designer!'],
                    ['name'=>'Anum B.','rating'=>4,'comment'=>'Love the bucket shape.']
                ]
            ],
            [
                'id'=>408,
                'category'=>'tote',
                'name'=>'Eco-Jute Market Tote',
                'price'=>3600,
                'image'=>'totebag12.jpg',
                'description'=>'Sustainable jute tote — durable and eco-friendly.',
                'reviews'=>[
                    ['name'=>'Rida A.','rating'=>5,'comment'=>'So natural and eco-conscious!'],
                    ['name'=>'Zoya F.','rating'=>4,'comment'=>'Love the earthy feel.']
                ]
            ],
        ];
    }
}
