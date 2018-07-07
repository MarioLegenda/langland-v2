<?php

namespace App\Web;

use Symfony\Component\HttpFoundation\Response;

class StaticController
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
        $content = $templating->render('static/index.html.twig');

        return new Response($content);
    }
    /**
     * @param \Twig_Environment $templating
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getGuide(\Twig_Environment $templating): Response
    {
        $content = $templating->render('static/index.html.twig');

        return new Response($content);
    }
    /**
     * @param \Twig_Environment $templating
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getSignUp(\Twig_Environment $templating): Response
    {
        $content = $templating->render('static/index.html.twig');

        return new Response($content);
    }
    /**
     * @param \Twig_Environment $templating
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function getSignIn(\Twig_Environment $templating): Response
    {
        $content = $templating->render('static/index.html.twig');

        return new Response($content);
    }
}