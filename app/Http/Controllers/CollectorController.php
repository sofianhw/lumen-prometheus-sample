<?php

namespace App\Http\Controllers;

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
	    \Prometheus\Storage\Redis::setDefaultOptions(
            [
                'host' => 'redis',
                'port' => 6379,
                'password' => null,
                'timeout' => 0.1, // in seconds
                'read_timeout' => '10', // in seconds
                'persistent_connections' => false
            ]
        );
	
        \Prometheus\CollectorRegistry::getDefault()
	        ->getOrRegisterCounter('', 'some_quick_counter', 'just a quick measurement')
    	    ->inc();

	    $registry = \Prometheus\CollectorRegistry::getDefault();

        $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
        $counter->incBy(2, ['blue']);

        $gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
        $gauge->set(4, ['blue']);

        $histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
        $histogram->observe(6, ['blue']);

        $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
        $counter->incBy(1, ['red']);

        $gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
        $gauge->set(3, ['red']);

        $histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
        $histogram->observe(5, ['red']);

        header('Content-type: text/html');
        echo "ok"
    }
}
