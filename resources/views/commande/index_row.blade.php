<tr class="ombrable" id="row_{{ $model->idcommande }}" >

       <!-- numero + date création -->
       <td>
               {{ $model->numero }}<br/>
               <span class="datecreation">{{ $model->datecreation }}</span>
       </td>


       <!-- client -->
       <td>
               @if(!is_null($model->client))
                       {{ $model->client->prenom }} {{ $model->client->nom }}
               @else
                       <span class="is_error_txt">Client inconnu !</span>
               @endif             
       </td>


       <!-- Paniers commandés -->
       <td class="lignes_commande">
               <table class="lignes_commande">
                       <tbody>
                               @foreach($model->lignes as $ligne)
                                       @include("commande.ligne")
                               @endforeach
                               <tr class="total">
                                       <td colspan="5">TOTAL :
                                       </td>
                                       <td>
                                               @prixFR($model->montant_total)
                                       </td>
                               </tr>
                       </tbody>
               </table>
       </td>


       <!-- livraison -->
       <td>
               @if(!is_null($model->livraison))
               {{ $model->livraison->date_livraison_enClair }}
               @else
               <span class="is_error_txt">
                       Livraison non identifiée
               </span>
               @endif
       </td>


       <!-- mode paiement -->
       <td>
               @if(!is_null($model->ModePaiement))
               {{ $model->ModePaiement->nom }}
               @else
               <span class="is_error_txt">
                       Mode de paiement non identifiée
               </span>
               @endif
       </td>


       <!-- relais -->
       <td>
               @if(!is_null($model->relais))
               {{ $model->relais->nom }}
               @else
               <span class="is_error_txt">
                       Relais non identifiée
               </span>
               @endif
       </td>


       <!-- statut -->
       <td class="{{$model->state}}">

               @if($model->statut == 'C_ARCHIVABLE')
               <form method="POST" name="livraison_archive" action="{{ URL::route('commande.archive', $model->id) }}">
                       {!! csrf_field() !!}
                       <input type="hidden" class="form-control" name="_method" value="PATCH">
                       <button class="btn btn-info btn-xs">
                               <i class="fa fa-btn fa-archive"></i>Archiver
                       </button>
               </form>
               @else
               {{ trans('constante.'.$model->statut) }}
               @endif
       </td>


</tr>