<?php

namespace Kdecom\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Basic action controller
 */
class FrontActionController extends AbstractActionController {
    public function test() {
        echo "test";
    }
}
