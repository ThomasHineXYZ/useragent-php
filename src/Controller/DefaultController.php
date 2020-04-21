<?php

namespace App\Controller;

use App\Agent;
use Symfony\Component\HttpFoundation\Response;

/**
 * What is the plan for this thing to do
 */
class DefaultController
{
    public function index()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        $agent = new Agent();
        $values = $agent->execute();

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
