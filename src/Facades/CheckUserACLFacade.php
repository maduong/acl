<?php namespace Edutalk\Base\ACL\Facades;

use Illuminate\Support\Facades\Facade;
use Edutalk\Base\ACL\Support\CheckCurrentUserACL;
use Edutalk\Base\ACL\Support\CheckUserACL;

class CheckUserACLFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CheckUserACL::class;
    }
}
