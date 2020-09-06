<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\categorySearch;
use App\Models\tatxProduct;
use App\Models\Seller;
use Exception;
use Goutte\Client;
class xmlCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmlCategory:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    $search = categorySearch::where('status','ON')->get();
// $target = str_replace(" ", "-", $search);
$sites = array(
/*[
    'uniqueID'      =>  'tamimi',

    'main'          => '.ZTYrd',
    'image'         => '.dkmYxt',
    'brand'         => '.jwWsjf',
    'name'          => '.cPmIdZ',
    'price'         => '.bWrtIK > span',
    'outofstock'    => '.ilYLaB',
    'oldPrice'      => '.ceJvfl',
    'moreBtn'       => 'NOTFOUND_NOTFOUND',

    'en' =>
    [   'url'       =>  'https://shop.tamimimarkets.com/category/######',
        'seller'   =>  'tamimi markets',
    ],
    'ar' =>
    [   'url'      =>  'https://shop.tamimimarkets.com/ar/category/######',
        'seller'   =>  'اسواق التميمي',
    ],
],
[
    'uniqueID'      =>  'carfour',

    'main'          => '.plp-list__item',
    'image'         => '.comp-productcard__img',
    'brand'         => 'NOTFOUND_NOTFOUND',
    'name'          => '.comp-productcard__name',
    'price'         => '.comp-productcard__price > strong',
    'outofstock'    => '.c--oos__text',
    'oldPrice'      => '.comp-productcard__price--was',
    'moreBtn'       => 'NOTFOUND_NOTFOUND',

    'en' =>
    [   'url'       =>  'https://www.carrefourksa.com/mafsau/en/######',
         'seller'   =>  'carefour',
    ],
    'ar' =>
    [   'url'      =>  'https://www.carrefourksa.com/mafsau/ar/######',
         'seller'   =>  'كارفور',
    ],
],*/
[
    'uniqueID'      =>  'panda',

    'main'          => '.wrap-item',
    'image'         => '.img-responsive',
    'brand'         => 'NOTFOUND_NOTFOUND',
    'name'          => '.product-name > a',
    'price'         => '.price .price',
    'outofstock'    => 'NOTFOUND_NOTFOUND',
    'oldPrice'      => '.price .old-price',
    'moreBtn'       => '.ias_trigger > a',

    'en' =>
    [   'url'       =>  'http://www.panda.com.sa/stores/dammam/######?___store=dammam_en',
    ],
    'ar' =>
    [   'url'      =>  'http://www.panda.com.sa/stores/dammam/######?___store=dammam_ar',
    ],
]/*,
[
    'uniqueID'      =>  'extra_stores',

    'main'          => '.c_item',
    'image'         => '.c_item--grid--thumb img',
    'brand'         => 'NOTFOUND_NOTFOUND',
    'name'          => '.c_item--grid--title > h3',
    'price'         => '.c_product-price-current',
    'outofstock'    => 'NOTFOUND_NOTFOUND',
    'oldPrice'      => '.c_product-price-previous',
    'moreBtn'       => '.ias_trigger > a',

    'en' =>
    [   'url'       =>  'https://www.extra.com/en-sa/######',
    ],
    'ar' =>
    [   'url'      =>  'https://www.extra.com/ar-sa/######',
    ],
],
[
    'uniqueID'      =>  'extra_stores',

    'main'          => '.c_product-tile',
    'image'         => '.image-container > img',
    'brand'         => 'NOTFOUND_NOTFOUND',
    'name'          => '.title',
    'price'         => '.c_product-price-current',
    'outofstock'    => 'NOTFOUND_NOTFOUND',
    'oldPrice'      => '.c_product-price-previous',
    'moreBtn'       => '.ias_trigger > a',

    'en' =>
    [   'url'       =>  'https://www.extra.com/en-sa/######',
    ],
    'ar' =>
    [   'url'      =>  'https://www.extra.com/ar-sa/######',
    ],
],
[
    'uniqueID'      =>  'aldawaa_pharmacy',

    'main'          => '.product-item-info',
    'image'         => '.product-image-photo',
    'brand'         => 'NOTFOUND_NOTFOUND',
    'name'          => '.product-item-link',
    'price'         => '.price',
    'outofstock'    => 'NOTFOUND_NOTFOUND',
    'oldPrice'      => '.NOTFOUND_NOTFOUND',
    'moreBtn'       => '.ias_trigger > a',

    'en' =>
    [   'url'       =>  'https://www.al-dawaa.com/english/######',
    ],
    'ar' =>
    [   'url'      =>  'https://www.al-dawaa.com/arabic/######',
    ],
],
[
    'uniqueID'      =>  'jarir_bookstore',

    'main'          => '.item',
    'image'         => '.product-image > img',
    'brand'         => 'NOTFOUND_NOTFOUND',
    'name'          => '.product-name > a',
    'price'         => '.price-box__col--price .price',
    'outofstock'    => 'NOTFOUND_NOTFOUND',
    'oldPrice'      => '.price--old',
    'moreBtn'       => '.ias_trigger > a',

    'en' =>
    [   'url'       =>  'https://www.jarir.com/sa-en/######',
    ],
    'ar' =>
    [   'url'      =>  'https://www.jarir.com/######',
    ],
]*/
);
/*    Start foreach For Elatamimi     */
$client = new Client();
foreach($search as $s){
    foreach($sites as $site){
        if($s['uniqueID'] != $site['uniqueID'])
            continue;
set_time_limit(300);
    $url = str_replace('######', $s['name'], $site[$s['language']]['url']);
    $this->info($url);    
    $GetSeller = Seller::where('uniqueID',$s['uniqueID'])->first();
    // if(!$GetSeller)
      // die('NOT FOUND !');
    $seller = ($s['language'] == 'en')? $GetSeller->name_en : $GetSeller->name_ar ;
    $language = $s['language'];
    $category = $s['category'];
    $sub_category = $s['sub_category'];
$crawler = $client->request('GET', $url);
if($crawler->filter($site['main'])->count() == 0)
  $crawler = $client->request('GET', $url);
$carrefour = $crawler->filter($site['main'])->each(function ($node) use ($category,$seller,$language,$site,$sub_category) {
  $image = ($node->filter($site['image'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['image'])->attr('src') ) : ''; 
  if(!$image)
    $image = ($node->filter($site['image'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['image'])->attr('data-src') ) : ''; 
  $brand = ($node->filter($site['brand'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['brand'])->text() ) . ' ' : '';
  $name  = ($node->filter($site['name'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['name'])->text() ) : '';
  $price = ($node->filter($site['price'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['price'])->text() ) : '';
$price = preg_match_all('!\d+\.?\d+!', $price ,$match)? (double)$match[0][0] : 0 ;

$outofstock = ($node->filter($site['outofstock'])->count() > 0) ? true : false ;
$oldPrice = ($node->filter($site['oldPrice'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['oldPrice'])->text() ) : 0;
/*str_replace(["\t","\n","  "], "", $node->filter('.bWrtIK > span')->text() )*/
// $this->info($category . '||' . $sub_category);
if($name == '' || $price == '' )
  return 0;
$Card = new tatxProduct();
        $Card->en = [
            "name" =>  "test",
            "brand" => "",
            "category" => "test",
            "sub_category" => "test",
            "seller" => "panda",
            "currency" => "sar",
            "desc"  => "Hello From Test",
        ];
        $Card->ar = [
            "name" =>  $name,
            "brand" => $brand,
            "category" => $category,
            "sub_category" => $sub_category,
            "seller" => $seller,
            "currency" => 'ريال',
            "desc"  => 'السعر شامل ضريبة القيمة المضافة',
        ];
        $Card->uniqueID = 'panda';
        $Card->image = $image;
        $Card->images = array();  
        $Card->bundle_product = array();
        $Card->options = array();
        $Card->price = $price;
        $Card->old_price =  0 ;
        $Card->dicount_percentage = 0;
        $Card->prepared_time = 0;
        $Card->is_outOfStock = $outofstock; 
        $Card->status = "ON";
        $Card->created_at = date('Y-m-d H:i:s');
        
        $Card->save();
  /*$Card = new tatxProduct(); 
  $Card->image = $image; 
  $Card->name =  $name;
  $Card->brand = $brand; 
  $Card->price = preg_match_all('!\d+\.?\d+!', $price ,$match)? (double)$match[0][0] : 0 ;
  $Card->currency = 'SAR';
  $Card->is_outOfStock = $outofstock;
  $Card->old_price = preg_match_all('!\d+\.?\d+!', $oldPrice ,$match)? (double)$match[0][0] : 0 ;
  $Card->category = $category ;
  $Card->sub_category = $sub_category;
  $Card->seller = $seller;
  $Card->uniqueID = $site['uniqueID'];
  $Card->status = 'ON';
  $Card->language = $language;
  $Card->created_at = date('Y-m-d H:i:s');

  $CHK = tatxProduct::where(array(
    'name'   =>  $Card->name,
    'seller' =>  $Card->seller,
  ))->first(); 
  if($CHK && $CHK->is_outOfStock != $Card->is_outOfStock )
      tatxProduct::where('name',$Card->name)->update([
          'is_outOfStock' => $outofstock
      ]);
  if($CHK && $CHK->price != $Card->price )
      tatxProduct::where('name',$Card->name)->update([
          'price'           => $Card->price,
          'old_price'       => $Card->old_price,
      ]);
  if(!$CHK){
    $this->info('ADD');
  $Card->save();
  }*/

 /* if($Card->uniqueID == 'panda' && !in_array($Card->sub_category, ['Diet Food','Seafood','Fresh Meats']) && !in_array($Card->sub_category, ['مأكولات للحميه','مأكولات بحرية','لحوم طازجة']) ){
    $Card->seller = ($language == 'en') ? 'baqalah' : 'البقالة';
    $Card->uniqueID = 'baqalah';
    if($Card->old_price != 0){
      $Card->price = $Card->old_price;
      $Card->old_price = 0;
    }
$CHK = tatxProduct::where(array(
    'name'   =>  $Card->name,
    'seller' =>  $Card->seller,
  ))->first() ;
  if($CHK && $CHK->is_outOfStock != $Card->is_outOfStock )
      tatxProduct::where('name',$Card->name)->update([
          'is_outOfStock' => $outofstock
      ]);
  if($CHK && $CHK->price != $Card->price )
      tatxProduct::where('name',$Card->name)->update([
          'price'           => $Card->price,
          'old_price'       => $Card->old_price,
      ]);
  if(!$CHK)
  $Card->save();
  }*/
});
}
}
/*    End foreach For Elatamimi     */
 

}

}
