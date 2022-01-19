<?php

namespace App\Http\Controllers;

use Prometheus\RenderTextFormat;

/**
 * Class MetriksController
 * @package App\Http\Controllers
 * This class contains the example route used
 * for testing purposes in this application
 */
class MetriksController extends Controller
{

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

        $registry = \Prometheus\CollectorRegistry::getDefault();

        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());

        header('Content-type: ' . RenderTextFormat::MIME_TYPE);
        echo $result;
    }

}
