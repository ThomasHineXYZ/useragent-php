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

        $splitAgent = [
            'device' => $agent->device(),
            'deviceType' => $this->deviceType($agent),
            'languages' => json_encode($agent->languages()),
            'platform' => $agent->platform(),
            'browser' => $this->grabBrowser($agent),
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

    private function grabBrowser(\Jenssegers\Agent\Agent $agent)
    {
        // Check over some niche ones won't show up normally
        if ($agent->match('^Links')) {
            return "Links";
        }

        return $agent->browser();
    }

}
