<?php

namespace Bsg\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BsgUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
