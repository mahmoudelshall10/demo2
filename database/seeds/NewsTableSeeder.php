<?php
use App\News;
use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $int = 2000; 
        // for($i = 0 ;$i < $int; $i++ )
        // {
        //     if($int%50 = 0){
        //         Sleep(10);
        //     }
            
        //     factory(News::class, $int)->create();
        // }
        // for ($i=0; $i < 50; $i++) {
            factory(News::class, 10)->create();
            // Sleep(10);
        // }
        
        

    }
}
