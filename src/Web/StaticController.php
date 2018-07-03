<?php

namespace App\Web;

use Symfony\Component\HttpFoundation\Response;

class StaticController
{

    public function getIndex(\Twig_Environment $templating): Response
    {
        $content = $templating->render('static/index.html.twig');

        return new Response($content);
    }
}