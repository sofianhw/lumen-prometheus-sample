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
    public function collect()
    {
        // retrieve the exporter (you can also use app('prometheus') or Prometheus::getFacadeRoot())
        $exporter = app(\Arquivei\LaravelPrometheusExporter\PrometheusExporter::class);

        // register a new collector
        $collector = new \My\New\Collector();
        $exporter->registerCollector($collector);

        // retrieve all collectors
        var_dump($exporter->getCollectors());

        // retrieve a collector by name
        $collector = $exporter->getCollector('user');

        // export all metrics
        // this is called automatically when the /metrics end-point is hit
        var_dump($exporter->export());

        // the following methods can be used to create and interact with counters, gauges and histograms directly
        // these methods will typically be called by collectors, but can be used to register any custom metrics directly,
        // without the need of a collector

        // create a counter
        $counter = $exporter->registerCounter('search_requests_total', 'The total number of search requests.');
        $counter->inc(); // increment by 1
        $counter->incBy(2);

        // create a counter (with labels)
        $counter = $exporter->registerCounter('search_requests_total', 'The total number of search requests.', ['request_type']);
        $counter->inc(['GET']); // increment by 1
        $counter->incBy(2, ['GET']);

        // retrieve a counter
        $counter = $exporter->getCounter('search_requests_total');

        // create a gauge
        $gauge = $exporter->registerGauge('users_online_total', 'The total number of users online.');
        $gauge->inc(); // increment by 1
        $gauge->incBy(2);
        $gauge->dec(); // decrement by 1
        $gauge->decBy(2);
        $gauge->set(36);

        // create a gauge (with labels)
        $gauge = $exporter->registerGauge('users_online_total', 'The total number of users online.', ['group']);
        $gauge->inc(['staff']); // increment by 1
        $gauge->incBy(2, ['staff']);
        $gauge->dec(['staff']); // decrement by 1
        $gauge->decBy(2, ['staff']);
        $gauge->set(36, ['staff']);

        // retrieve a gauge
        $counter = $exporter->getGauge('users_online_total');

        // create a histogram
        $histogram = $exporter->registerHistogram(
            'response_time_seconds',
            'The response time of a request.',
            [],
            [0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0]
        );
        // the buckets must be in asc order
        // if buckets aren't specified, the default 0.005, 0.01, 0.025, 0.05, 0.075, 0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0 buckets will be used
        $histogram->observe(5.0);

        // create a histogram (with labels)
        $histogram = $exporter->registerHistogram(
            'response_time_seconds',
            'The response time of a request.',
            ['request_type'],
            [0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0]
        );
        // the buckets must be in asc order
        // if buckets aren't specified, the default 0.005, 0.01, 0.025, 0.05, 0.075, 0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0 buckets will be used
        $histogram->observe(5.0, ['GET']);

        // retrieve a histogram
        $counter = $exporter->getHistogram('response_time_seconds');
    }
}
