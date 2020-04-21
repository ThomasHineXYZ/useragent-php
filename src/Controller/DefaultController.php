<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Agent;

/**
 * What is the plan for this thing to do
 */
class DefaultController
{
    public function index()
    {
        $agent = new Agent();
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        $values = $agent->execute($userAgent);

        $output = "";
        foreach ($values as $key => $value) {
            $output .= ucwords($key) . ": " . $value . "<br/>";
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
                    Your User-Agent is:<br/>
                    ${userAgent}<br/>
                    <br/>
                    ${output}<br/>
                </body>
            </html>
        ");
    }
}
