<?php

namespace App;

use App\SQL\SQL;
use Jenssegers\Agent\Agent as JenssegersAgent;

/**
 * Splits up the browser's useragent, and stores it
 */
class Agent
{
    private $db;

    public function __construct()
    {
        // Set up DB access with PDO
        $sql = new SQL();
        $this->db = $sql->set("UserAgent");
    }

    public function execute()
    {
        $agent = new JenssegersAgent();

        $splitAgent = [
            'device' => $agent->device(),
            'deviceType' => $this->getDeviceType($agent),
            'languages' => json_encode($agent->languages()),
            'platform' => $this->getPlatform($agent),
            'browser' => $this->getBrowser($agent),
        ];

        $this->store($agent->getUserAgent(), $splitAgent);

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
        } elseif ($agent->match('Nintendo WiiU')) {
            return "WiiU Browser";
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

    /**
     * Grabs the name of the browser, checking it against a custom list first
     *
     * @param  \Jenssegers\Agent\Agent $agent
     *
     * @return string
     */
    private function getPlatform(\Jenssegers\Agent\Agent $agent)
    {
        // Check over some niche devices
        if ($agent->match('Nintendo WiiU')) {
            return "Nintendo WiiU";
        } elseif ($agent->match('Nintendo')) {
            return "Nintendo device";
        }

        // If it's none of the above, return what the parser found
        return $agent->platform();
    }

    private function store(string $userAgent, array $split)
    {
        $query = $this->db->prepare("
            INSERT INTO user_agents (
                user_agent,
                device,
                device_type,
                languages,
                platform,
                browser
            ) VALUES (
                :user_agent,
                :device,
                :device_type,
                :languages,
                :platform,
                :browser
            )
            ON DUPLICATE KEY UPDATE
                device = VALUES(device),
                device_type = VALUES(device_type),
                languages = VALUES(languages),
                platform = VALUES(platform),
                browser = VALUES(browser)
            ;
        ");

        $query->execute([
            ":user_agent" => $userAgent,
            ":device" => $split['device'],
            ":device_type" => $split['deviceType'],
            ":languages" => $split['languages'],
            ":platform" => $split['platform'],
            ":browser" => $split['browser'],
        ]);
    }
}
