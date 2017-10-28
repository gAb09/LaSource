<?php namespace Gab\Helpers;
 
use Illuminate\Support\Facades\Facade;
 
class DateFrFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'DateFr'; }
 
}