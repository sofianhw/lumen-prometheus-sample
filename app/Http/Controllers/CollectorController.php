<?php

namespace App\Http\Controllers;

use Arquivei\LaravelPrometheusExporter\PrometheusExporter;
use Arquivei\LaravelPrometheusExporter\PrometheusServiceProvider;
use Arquivei\LaravelPrometheusExporter\StorageAdapterFactory;
use Prometheus\Storage\Adapter;

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
        $registry = new Arquivei\LaravelPrometheusExporter\PrometheusExporter;
        $histogram = $registry->registerHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
        $histogram->observe($_GET['c'], ['blue']);
        echo "OK\n";
    }
}
