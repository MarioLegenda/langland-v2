<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use Symfony\Component\HttpFoundation\Response;

class StaticEntryPoint
{

    public function getIndex(\Twig_Environment $templating): Response
    {
        $content = $templating->render('static/index.html.twig');

        return new Response($content);
    }
}