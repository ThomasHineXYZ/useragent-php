<?php

namespace App;

use Jenssegers\Agent\Agent as JAgent;

/**
 * What is the plan for this thing to do
 */
class Agent
{
    public function execute($userAgent)
    {
        $agent = new JAgent();

        $agent->setUserAgent($userAgent);

        // echo "<pre>";
        // print_r($agent);
        // echo "</pre>";
        // exit();

        $splitAgent = [
            'device' => $agent->device(),
            'languages' => implode(", ", $agent->languages()),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
        ];

        return $splitAgent;
    }

}
