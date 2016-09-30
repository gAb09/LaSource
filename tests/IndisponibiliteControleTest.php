<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Livraison;

class IndisponibiliteControleTest extends TestCase
{

    use DatabaseMigrations;

    // The base URL to use while testing the application.
    protected $baseUrl = 'http://lasource';



    public function testExample()
    {
        $datas = [
            // 'date_livraison' => '2016-09-26 00:00:00',
            'date_cloture' => '2017-09-26 00:00:00',
            'date_paiement' => '2018-09-26 00:00:00',
            'is_actived' => 1,
            ];

        $livraison = Livraison::create($datas);

        // $livraison->date_livraison = '2016-09-26 00:00:00';
        // $livraison->is_actived = 123;
        // $livraison->save();

        // $this->assertTrue($livraison->id == 1);

        // $users = DB::table('livraisons')->where('id', 1)->get();
        // $this->assertTrue($users->id == 1);

        $test = Livraison::find(1);
        // dd($test->state);
        $this->assertTrue($test->id == 1);

    }


}
