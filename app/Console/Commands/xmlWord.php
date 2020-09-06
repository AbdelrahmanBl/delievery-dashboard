<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\wordSearch;
use App\Models\tatxProduct;
use Exception;
use Goutte\Client;
class xmlWord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmlWord:cron';

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
        $search = wordSearch::where('status',true)->get();
    // $target = str_replace(" ", "-", $search);
    $sites = array(
    [
        'uniqueID'      =>  'tamimi',
        
        'main'          => '.ZTYrd',
        'image'         => '.dkmYxt',
        'brand'         => '.jwWsjf',
        'name'          => '.cPmIdZ',
        'price'         => '.bWrtIK > span',
        'outofstock'    => '.ilYLaB',
        'oldPrice'      => '.ceJvfl',

        'en' =>
        [   'url'       =>  'https://shop.tamimimarkets.com/search?query=######',
            'seller'   =>  'tamimi markets',
        ],
        'ar' =>
        [   'url'      =>  'https://shop.tamimimarkets.com/ar/search?query=######',
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

        'en' =>
        [   'url'       =>  'https://www.carrefourksa.com/mafsau/en/v1/search=######',
            'seller'   =>  'carefour',
        ],
        'ar' =>
        [   'url'      =>  'https://www.carrefourksa.com/mafsau/ar/v1/search=######',
            'seller'   =>  'كارفور',
        ],
    ]
);
/*    Start foreach For Elatamimi     */
$client = new Client();
    foreach($search as $s){
        foreach($sites as $site){
    set_time_limit(300);
        $url = str_replace('######', $s['name'], $site[$s['language']]['url']);
        $this->info($url);
        $GetSeller = Seller::where('uniqueID',$s['uniqueID'])->first();
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

    $brand = ($node->filter($site['brand'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['brand'])->text() ) : '';
    $name  = ($node->filter($site['name'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['name'])->text() ) : '';
    $price = ($node->filter($site['price'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['price'])->text() ) : '';
    $outofstock = ($node->filter($site['outofstock'])->count() > 0) ? true : false ;
    $oldPrice = ($node->filter($site['oldPrice'])->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($site['oldPrice'])->text() ) : 0;
    /*str_replace(["\t","\n","  "], "", $node->filter('.bWrtIK > span')->text() )*/
if($name == '' || $price == '')
  return 0;    
    $Card = new tatxProduct();
    $Card->image = $image; 
    $Card->name =  $brand . $name;
    $Card->price = preg_match_all('!\d+\.?\d+!', $price ,$match)? (double)$match[0][0] : 0 ;
    $Card->currency = 'SAR';
    $Card->is_outOfStock = $outofstock;
    $Card->old_price = preg_match_all('!\d+\.?\d+!', $oldPrice ,$match)? (double)$match[0][0] : 0 ;
    $Card->category = $category ;
    $Card->sub_category = $sub_category;
    $Card->seller = $seller;
    $Card->uniqueID = $site['uniqueID'];
    $Card->status = true;
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
            'price'         => $Card->price,
            'old_price'     => $Card->old_price,
        ]);
    if(!$CHK)
    $Card->save();
    });
  }
}
/*    End foreach For Elatamimi     */
    }
}
