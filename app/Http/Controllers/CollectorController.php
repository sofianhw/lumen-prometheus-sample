<?php

namespace App\Http\Controllers;

use Prometheus\Gauge;


/**
 * Class CollectorController
 * @package App\Http\Controllers
 * This class contains the example route used
 * for testing purposes in this application
 */
class CollectorController extends Controller
{
    //**
    * @var Gauge
    */
   protected $usersRegisteredGauge;

   /**
    * Return the name of the collector.
    *
    * @return string
    */
   public function getName() : string
   {
       return 'users';
   }

   /**
    * Register all metrics associated with the collector.
    *
    * The metrics needs to be registered on the exporter object.
    * eg:
    * ```php
    * $exporter->registerCounter('search_requests_total', 'The total number of search requests.');
    * ```
    *
    * @param PrometheusExporter $exporter
    */
    public function registerMetrics(PrometheusExporter $exporter) : void
    {
        $this->usersRegisteredGauge = $exporter->registerGauge(
            'users_registered_total',
            'The total number of registered users.',
            ['group']
        );
    }

    /**
        * Collect metrics data, if need be, before exporting.
        *
        * As an example, this may be used to perform time consuming database queries and set the value of a counter
        * or gauge.
        */
    public function collect() : void
    {
        // retrieve the total number of staff users registered
        // eg: $totalUsers = Users::where('group', 'staff')->count();
        $this->usersRegisteredGauge->set(36, ['staff']);

        // retrieve the total number of regular users registered
        // eg: $totalUsers = Users::where('group', 'regular')->count();
        $this->usersRegisteredGauge->set(192, ['regular']);
    }
}
