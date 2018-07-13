<?php

namespace App\Web;

use Symfony\Component\HttpFoundation\Response;

class AdminStaticController
{
    /**
     * @param \Twig_Environment $templating
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getIndex(\Twig_Environment $templating): Response
    {
        $content = $templating->render('admin/static/index.html.twig');

        return new Response($content);
    }
}