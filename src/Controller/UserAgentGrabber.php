<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * What is the plan for this thing to do
 */
class UserAgentGrabber
{
    public function page()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $number = random_int(0, 100);

        return new Response("
            <html>
                <body>
                    Your User-Agent is: <br/>
                    ${userAgent}
                </body>
            </html>
        ");
    }
}
