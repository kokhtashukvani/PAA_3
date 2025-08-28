<?php

class ErrorController
{
    /**
     * Display the 404 Not Found page.
     */
    public function notFound()
    {
        http_response_code(404);
        load_view('errors/404');
    }
}
