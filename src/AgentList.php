<?php

namespace App;

use App\SQL\SQL;

/**
 * Grabs the list of user agents, and returns it.
 */
class AgentList
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
        $query = $this->db->query("
            SELECT user_agent
            FROM user_agents
            ORDER BY last_seen DESC;
        ");

        return $query->fetchAll();
    }
}
