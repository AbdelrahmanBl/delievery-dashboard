<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Storage;
use App\HASEPAT;
class FCI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FCI:cron';

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
/**************************************************************/
/**********************    Start   ****************************/
/**************************************************************/
    $this->info('Start ...');
$client = new Client();
set_time_limit(300);
/**************************************************************/
/*******************    Set Settings   ************************/
/**************************************************************/
$status = 'GENERATING';//GENERATING     &&   SCRPING
$mode = 'DEVELOPEMENT';//NOT_DEVELOPEMENT    &&  DEVELOPEMENT
$page = 'https://iqsanswers.com/data-warehouse-multiple-choice-questions-and-answers/';
$start_counter  = 0;
$filename       = 'Distributed_Database.txt';
$filename_copy  = 'Distributed_Database - Copy.txt';
//---------------------------------------------------------//
$main           = '.entry-content > div:nth-child(2) p';
$c              = '.bix-td-qno';
$q              = '.entry-content';
$r1             = 'p:nth-child(1)';
$r2             = 'p:nth-child(2)';
$r3             = 'p:nth-child(3)';
$r4             = 'p:nth-child(4)';
$t              = '.jq-hdnakqb';
$display_option = 'Option ';
/**************************************************************/
/**********************    Looping   ****************************/
/**************************************************************/
if($status == 'SCRPING'){
    for($i = 1 ; $i <= 1 ; $i++){
      $url = $page;
    // $url = str_replace('######', $i, $page);
    $this->info($url);
$crawler = $client->request('GET', $url);
// if($crawler->filter($site['main'])->count() == 0)
  // $crawler = $client->request('GET', $url);
$scrap = $crawler->filter($main)->each(function ($node) use($main,$c,$q,$r1,$r2,$r3,$r4,$t,$start_counter,$filename,$filename_copy,$display_option,$mode) {
    $int = ($node->filter($c)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($c)->text() ) : ''; 
    $counter = (int) filter_var($int, FILTER_SANITIZE_NUMBER_INT) + $start_counter;
    $question = ($node->filter($q)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($q)->text() ) : ''; 
    $rspond1 = ($node->filter($r1)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r1)->text() ) : ''; 
    $rspond2 = ($node->filter($r2)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r2)->text() ) : ''; 
    $rspond3 = ($node->filter($r3)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r3)->text() ) : ''; 
    $rspond4 = ($node->filter($r4)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r4)->text() ) : ''; 
    $true = ($node->filter($t)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($t)->text() ) : ''; 

    $items = array($rspond1,$rspond2,$rspond3,$rspond4);
    $responds = array();
    $C = 0;
        foreach($items as $item){
        if($item){
            $str = str_replace(".",") ",str_replace(". ", ".", $item));
            $responds[$C] = ($str[strlen($str)-1] == " ")? substr_replace($str,".",strlen($str)-2) : substr_replace($str,".",strlen($str));
            $C++;
        }
    }
    if($mode == 'DEVELOPEMENT'){
    $this->info('-----------------------------------');
    $this->info($counter);
    $this->info($question);
    $this->info((count($responds) >= 1)?$responds[0]:'');
    $this->info((count($responds) >= 2)?$responds[1]:'');
    $this->info((count($responds) >= 3)?$responds[2]:'');
    $this->info((count($responds) >= 4)?$responds[3]:'');
    $this->info($display_option.$true);
    die('END...');
    }
    $found = HASEPAT::where('question',$question)->first();
    // $contents = Storage::get($filename_copy); 
    // $pattern = preg_quote($question, '/');
    // $pattern = "/^.*$pattern.*\$/m";
    // if(preg_match_all($pattern, $contents, $matches))
    // $found = true;
    // $this->info($found);

    if($question != '' && !$found){
    $FCI = new HASEPAT();
    $FCI->question       = $question;
    $FCI->rspond1        = (count($responds) >= 1)? $responds[0]:'';
    $FCI->rspond2        = (count($responds) >= 2)? $responds[1]:'';
    $FCI->rspond3        = (count($responds) >= 3)? $responds[2]:'';
    $FCI->rspond4        = (count($responds) >= 4)? $responds[3]:'';
    $FCI->true           = $display_option.$true;
    $FCI->save();
    $this->info($counter);
    }   
  });
    }
   }else{
    // if(Storage::exists($filename))
    //     $txt = Storage::get($filename); 
    //     else  $txt = '';      
    $txt = '';    
    $FCI = HASEPAT::get();
    $counter = 1;
    foreach($FCI as $F){
        // $txt .= '<div class="question">'.PHP_EOL;
        // $txt .=  '<h6>'. "[".($counter++) . "] " . $F->question.'</h6>'.PHP_EOL;
        $txt .=  "[".($counter++) . "] " . $F->question.PHP_EOL;
        $items = array($F->rspond1,$F->rspond2,$F->rspond3,$F->rspond4);
        // $txt .= '<p class="d-flex flex-column">'.PHP_EOL;
        foreach($items as $item){
        if($item){
            // $txt .= '<span>'. $item .'</span>'. PHP_EOL ;
            $txt .= $item . PHP_EOL ;
        }
    }
    // $txt .= '<span class="mt-1"><strong style="background-color: #bbffbe; border-radius: 4px; padding: 5px">'.'Answer: '.$F->true.'</strong></span>'.PHP_EOL;
    $txt .= 'Answer: '.$F->true.PHP_EOL;
    // $txt .= '</p>'.PHP_EOL;
    // $txt .= '</div>'.PHP_EOL;
    Storage::put($filename, $txt); 
    }
   }
  } 
}
/**************************************************************/
/*******************    Used WebSites   ***********************/
/**************************************************************/
// $page = 'https://www.examveda.com/database/practice-mcq-question-on-distributed-databases/?page=######';
// $main           = '.question';
// $c              = '.question-number';
// $q              = '.question-main';
// $r1             = '.question-options > p:nth-child(1)';
// $r2             = '.question-options > p:nth-child(2)';
// $r3             = '.question-options > p:nth-child(3)';
// $r4             = '.question-options > p:nth-child(4)';
// $t              = '.page-content strong';
// $display_option = '';
// LOOPING   =>>>  1 To 6 
/**************************************************************/
// $page = 'https://www.indiabix.com/database/distributed-databases/######';
// $main           = '.bix-div-container';
// $c              = '.bix-td-qno';
// $q              = '.bix-td-qtxt > p';
// $r1             = '.bix-tbl-options > tr:nth-child(1)';
// $r2             = '.bix-tbl-options > tr:nth-child(2)';
// $r3             = '.bix-tbl-options > tr:nth-child(3)';
// $r4             = '.bix-tbl-options > tr:nth-child(4)';
// $t              = '.jq-hdnakqb';
// $display_option = 'Option ';
// LOOPING   =>>>  225001 To 225003  &&  226001 To 226003
/**************************************************************/
// $page = 'https://compscibits.com/mcq-questions/DBMS/Distributed-Databases/######';
// $main           = '.quescontainer';
// $c              = '.table-striped tr:nth-child(1) span';
// $q              = '.questionpre';
// $r1             = '#questable tr:nth-child(2) .questionpre';
// $r2             = '#questable tr:nth-child(3) .questionpre';
// $r3             = '#questable tr:nth-child(4) .questionpre';
// $r4             = '#questable tr:nth-child(5) .questionpre';
// $t              = '.ans-Div > span:nth-child(2)';
// $display_option = ' Option ';
// LOOPING   =>>>  1 To 5
/**************************************************************/




/*
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Storage;
use App\HASEPAT;
class FCI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//     protected $signature = 'FCI:cron';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Command description';

//     /**
//      * Create a new command instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     /**
//      * Execute the console command.
//      *
//      * @return mixed
//      */
//     public function handle()
//     {
// /**************************************************************/
// /**********************    Start   ****************************/
// /**************************************************************/
//     $this->info('Start ...');
// $client = new Client();
// set_time_limit(300);
// /**************************************************************/
// /*******************    Set Settings   ************************/
// /**************************************************************/
// $status = 'SCRPING';//GENERATING     &&   SCRPING

// $page = 'https://www.latestinterviewquestions.com/data-warehouse-multiple-choice-questions-answers';
// $start_counter  = 0;
// $filename       = 'Distributed_Database.txt';
// $filename_copy  = 'Distributed_Database - Copy.txt';
// //---------------------------------------------------------//
// $main           = '.bg-wbs';
// $c              = '.table-striped tr:nth-child(1) span';
// $q              = 'h3:nth-child(';  
// $r1             = 'p:nth-child(';   
// $r2             = 'p:nth-child(';   
// $r3             = 'p:nth-child(';   
// $r4             = 'p:nth-child(';   
// $t              = 'p:nth-child(';   
// $display_option = '';//' Option ';
// $mode = 'DEVELOPEMENTZ';//NOT_DEVELOPEMENT    &&  DEVELOPEMENT
// /**************************************************************/
// /**********************    Looping   ****************************/
// /**************************************************************/
// $url = $page;
// $crawler = $client->request('GET', $url);
// $this->info($url);
// if($status == 'SCRPING'){
//     for($i = 45 ; $i <= 51 ; $i++){
      
//     // $url = str_replace('######', $i, $page);
    

// // if($crawler->filter($site['main'])->count() == 0)
//   // $crawler = $client->request('GET', $url);
// $scrap = $crawler->filter($main)->each(function ($node) use($main,$c,$q,$r1,$r2,$r3,$r4,$t,$start_counter,$filename,$filename_copy,$display_option,$mode,$i) {
//     $int = ($node->filter($c)->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($c)->text() ) : ''; 
//     $NO = -12;
//     $counter = (int) filter_var($int, FILTER_SANITIZE_NUMBER_INT) + $start_counter;
//     $question = ($node->filter($q.(13+$NO+(7*$i)).')')->count() > 0) ? explode('. ',str_replace(["\t","\n","  "], "", $node->filter($q.(13+$NO+(7*$i)).')')->text() ))[1] : ''; 
//     $rspond1 = ($node->filter($r1.(14+$NO+(7*$i)).')')->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r1.(14+$NO+(7*$i)).')')->text() ) : ''; 
//     $rspond2 = ($node->filter($r2.(15+$NO+(7*$i)).')')->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r2.(15+$NO+(7*$i)).')')->text() ) : ''; 
//     $rspond3 = ($node->filter($r3.(16+$NO+(7*$i)).')')->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r3.(16+$NO+(7*$i)).')')->text() ) : ''; 
//     $rspond4 = ($node->filter($r4.(17+$NO+(7*$i)).')')->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($r4.(17+$NO+(7*$i)).')')->text() ) : ''; 
//     $true = ($node->filter($t.(18+$NO+(7*$i)).')')->count() > 0) ? str_replace(["\t","\n","  "], "", $node->filter($t.(18+$NO+(7*$i)).')')->text() ) : ''; 

//     $items = array($rspond1,$rspond2,$rspond3,$rspond4);
//     $responds = array();
//     $C = 0;
//         foreach($items as $item){
//         if($item){
//             $str = str_replace(".",") ",str_replace(". ", ".", $item));
//             $responds[$C] = ($str[strlen($str)-1] == " ")? substr_replace($str,".",strlen($str)-2) : substr_replace($str,".",strlen($str));
//             $C++;
//         }
//     }
//     if($mode == 'DEVELOPEMENT'){
//     $this->info('-----------------------------------');
//     $this->info($counter);
//     $this->info($question);
//     $this->info((count($responds) >= 1)?$responds[0]:'');
//     $this->info((count($responds) >= 2)?$responds[1]:'');
//     $this->info((count($responds) >= 3)?$responds[2]:'');
//     $this->info((count($responds) >= 4)?$responds[3]:'');
//     $this->info($display_option.$true);
//     die('END...');
//     }
//     // $found = HASEPAT::where('question',$question)->first();


//     // $contents = Storage::get($filename_copy); 
//     // $pattern = preg_quote($question, '/');
//     // $pattern = "/^.*$pattern.*\$/m";
//     // if(preg_match_all($pattern, $contents, $matches))
//     // $found = true;
//     // $this->info($found);

//     if($question != '' /*&& !$found*/){
//     $FCI = new HASEPAT();
//     $FCI->question       = $question;
//     $FCI->rspond1        = (count($responds) >= 1)?$responds[0]:'';
//     $FCI->rspond2        = (count($responds) >= 2)?$responds[1]:'';
//     $FCI->rspond3        = (count($responds) >= 3)?$responds[2]:'';
//     $FCI->rspond4        = (count($responds) >= 4)?$responds[3]:'';
//     $FCI->true           = $display_option.$true;
//     $FCI->save();
//     $this->info($counter);
//     }   
//   });
//     }
//    }else{
//     // if(Storage::exists($filename))
//     //     $txt = Storage::get($filename); 
//     //     else  $txt = '';      
//     $txt = '';    
//     $FCI = HASEPAT::get();
//     $counter = 1;
//     foreach($FCI as $F){
//         $txt .= '<div class="question">'.PHP_EOL;
//         $txt .=  '<h6>'. "[".($counter++) . "] " . $F->question.'</h6>'.PHP_EOL;
//         $items = array($F->rspond1,$F->rspond2,$F->rspond3,$F->rspond4);
//         $txt .= '<p class="d-flex flex-column">'.PHP_EOL;
//         foreach($items as $item){
//         if($item){
//             $txt .= '<span>'. $item .'</span>'. PHP_EOL ;
//         }
//     }
//     $txt .= '<span class="mt-1"><strong style="background-color: #bbffbe; border-radius: 4px; padding: 5px">'.'Answer: '.$F->true.'</strong></span>'.PHP_EOL;
//     $txt .= '</p>'.PHP_EOL;
//     $txt .= '</div>'.PHP_EOL;
//     Storage::put($filename, $txt); 
//     }
//    }
//   } 
// }
/**************************************************************/
/*******************    Used WebSites   ***********************/
/**************************************************************/
// $page = 'https://www.examveda.com/database/practice-mcq-question-on-distributed-databases/?page=######';
// $main           = '.question';
// $c              = '.question-number';
// $q              = '.question-main';
// $r1             = '.question-options > p:nth-child(1)';
// $r2             = '.question-options > p:nth-child(2)';
// $r3             = '.question-options > p:nth-child(3)';
// $r4             = '.question-options > p:nth-child(4)';
// $t              = '.page-content > strong';
// $display_option = '';
// LOOPING   =>>>  1 To 6 
/**************************************************************/
// $page = 'https://www.indiabix.com/database/distributed-databases/######';
// $main           = '.bix-div-container';
// $c              = '.bix-td-qno';
// $q              = '.bix-td-qtxt > p';
// $r1             = '.bix-tbl-options > tr:nth-child(1)';
// $r2             = '.bix-tbl-options > tr:nth-child(2)';
// $r3             = '.bix-tbl-options > tr:nth-child(3)';
// $r4             = '.bix-tbl-options > tr:nth-child(4)';
// $t              = '.jq-hdnakqb';
// $display_option = 'Option ';
// LOOPING   =>>>  225001 To 225003  &&  226001 To 226003
/**************************************************************/
// $page = 'https://compscibits.com/mcq-questions/DBMS/Distributed-Databases/######';
// $main           = '.quescontainer';
// $c              = '.table-striped tr:nth-child(1) span';
// $q              = '.questionpre';
// $r1             = '#questable tr:nth-child(2) .questionpre';
// $r2             = '#questable tr:nth-child(3) .questionpre';
// $r3             = '#questable tr:nth-child(4) .questionpre';
// $r4             = '#questable tr:nth-child(5) .questionpre';
// $t              = '.ans-Div > span:nth-child(2)';
// $display_option = ' Option ';
// LOOPING   =>>>  1 To 5
/**************************************************************/
