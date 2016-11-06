<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Livraison;
use App\Domaines\IndisponibiliteDomaine as IndispoD;
use App\Domaines\RelaisDomaine as relaisD;
use App\Domaines\LivraisonDomaine;
use Carbon\Carbon;

class IndisponibiliteModifyLivraisonTest extends TestCase
{

    use DatabaseMigrations;

    // The base URL to use while testing the application.
    protected $baseUrl = 'http://lasource';


    protected function setUp()
    {
        Parent::setUp();
        $livraisonD = new LivraisonDomaine;
        $relaisD = new relaisD($livraisonD);
        $this->indispoD = new IndispoD($relaisD);
    }


    public function testHasLivraisonsExtended()
    {
        $date_debut = Carbon::now();
        $date_fin = $date_debut->addDays(30);

        $resultat = $this->indispoD->hasLivraisonsExtended($date_debut, $date_fin);

        $this->assertFalse($resultat);

        $livraison_1 = Livraison::create([
            'date_cloture' => $date_debut->subDays(15),
            'date_paiement' => $date_debut,
            'date_livraison' => $date_debut->addDays(15),
            'is_actived' => 1,
            ]);

        $resultat = $this->indispoD->hasLivraisonsExtended($date_debut, $date_fin);

        $this->assertTrue($resultat);


    }

    public function testHasLivraisonsRestricted()
    {
        $date_debut = Carbon::now();
        $date_fin = $date_debut->addDays(30);
        $resultat = $this->indispoD->hasLivraisonsRestricted($date_debut, $date_fin);

        $this->assertFalse($resultat);

        $livraison_1 = Livraison::create([
            'date_cloture' => $date_debut->subDays(15),
            'date_paiement' => $date_debut,
            'date_livraison' => $date_debut->addDays(15),
            'is_actived' => 1,
            ]);

        $resultat = $this->indispoD->hasLivraisonsRestricted($date_debut, $date_fin);

        $this->assertTrue($resultat);


    }


}
