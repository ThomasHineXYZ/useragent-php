<?php

namespace App\Controller;

use App\AgentList;
use Symfony\Component\HttpFoundation\Response;

/**
 * What is the plan for this thing to do
 */
class ListController
{
    public function list()
    {
        $agentList = new AgentList();
        $agents = $agentList->execute();

        $output = "";
        foreach ($agents as $key => $agent) {
            $output .= $agent->user_agent . "<br/>";
        }

        return new Response("
            <html>
                <style>
                    body {
                        background-color: #151515;
                        color: #FFFFFF;
                    }
                </style>
                <body>
                    ${output}
                </body>
            </html>
        ");
    }
}
