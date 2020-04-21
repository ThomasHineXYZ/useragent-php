<?php

namespace App;

use Jenssegers\Agent\Agent as JAgent;

/**
 * What is the plan for this thing to do
 */
class Agent
{
    public function execute()
    {
        $agent = new JAgent();

        echo "<pre>";
        print_r($agent);
        echo "</pre>";
        exit();

        $splitAgent = [
            'device' => $agent->device(),
            'deviceType' => $this->deviceType($agent),
            'languages' => implode(", ", $agent->languages()),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
        ];

        return $splitAgent;
    }

    private function deviceType(\Jenssegers\Agent\Agent $agent)
    {
        if ($agent->isDesktop()) {
            return "desktop";
        } elseif ($agent->isPhone()) {
            return "phone";
        } elseif ($agent->isTablet()) {
            return "tablet";
        } elseif ($agent->isRobot()) {
            return "robot";
        }

        return "other";
    }
}
