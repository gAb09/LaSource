Votre login est : 
Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
