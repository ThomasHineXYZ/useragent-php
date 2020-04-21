<?php

namespace App;

use App\SQL\SQL;

/**
 * What is the plan for this thing to do
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
            ORDER BY stored DESC;
        ");

        return $query->fetchAll();
    }
}
