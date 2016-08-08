<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait setRangsTrait
{
    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }

}
