<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

/**
 * Class ExampleController
 * @package App\Http\Controllers
 * This class contains the example route used
 * for testing purposes in this application
 */
class CollectorController extends Controller
{
    /**
     * Route used to test anything that requires
     * a working action.
     *
     * @throws Exception
     */
    public function collect()
    {
        $adapter = new Prometheus\Storage\Redis();
        $registry = new CollectorRegistry($adapter);
        $histogram = $registry->registerHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
        $histogram->observe($_GET['c'], ['blue']);
    }
}
