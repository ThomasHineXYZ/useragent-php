<?php

namespace App;

use Jenssegers\Agent\Agent as JAgent;

/**
 * Splits up the browser's useragent, and stores it
 */
class Agent
{
    public function execute()
    {
        $agent = new JAgent();

        $splitAgent = [
            'device' => $agent->device(),
            'deviceType' => $this->getDeviceType($agent),
            'languages' => json_encode($agent->languages()),
            'platform' => $agent->platform(),
            'browser' => $this->getBrowser($agent),
        ];

        return $splitAgent;
    }

    /**
     * Grabs the name of the browser, checking it against a custom list first
     *
     * @param  \Jenssegers\Agent\Agent $agent
     *
     * @return string
     */
    private function getBrowser(\Jenssegers\Agent\Agent $agent)
    {
        // Check over some niche ones won't show up normally
        if ($agent->match('^Links')) {
            return "Links";
        }

        // If it's none of the above, return what the parser found
        return $agent->browser();
    }

    /**
     * Returns what the device type is
     *
     * @param  \Jenssegers\Agent\Agent $agent
     *
     * @ref https://github.com/jenssegers/agent/blob/1c983bda80868a46c08cb4fe8a708fb3e9ea1197/src/Agent.php#L308
     *
     * @return string
     */
    private function getDeviceType(\Jenssegers\Agent\Agent $agent)
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
