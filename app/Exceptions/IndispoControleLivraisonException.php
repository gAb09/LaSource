<?php
namespace App\Exceptions;

use \Exception;

class IndispoControleLivraisonException extends Exception
{

  public function __construct($complement = '', $code = 0)
  {
  	if ($complement) {
  		$complement = '<br />“'.$complement.'”';
  	}
  	$message = trans('message.indisponibilite.controleFailed').$complement.trans('message.bug.transmis');
    parent::__construct($message, $code);
  }
  
}