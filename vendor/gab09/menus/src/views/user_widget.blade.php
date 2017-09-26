@if(isset(Auth::user()->login ))
<p style="font-size:0.9em;margin-bottom:0px;display:inline">Utilisateur connecté : </p>

<span onClick="javascript:document.location.href='/dashboard';">{{ Auth::user()->login }}</span>

{{Form::button('Déconnexion', array('class' => 'btn btn-danger btn-mini iconesmall delete', 'style' => '', 
'OnClick' => 'document.location.href="/deconnexion";' ))}}
@endif

