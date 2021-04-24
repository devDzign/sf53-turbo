<?php


namespace App\Services;


use phpDocumentor\Reflection\Types\Self_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class HandleFormService extends AbstractController
{

    private Environment $twig;
    private array $params= [];
    private string $template;
    private bool $isInitialize= false;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

    }

    public function initialize(string $template, array $params= []): self
    {
        $this->template = $template;
        $this->params = $params;
        $this->isInitialize=true;
        return $this;
    }

    public  function onSuccess(FormInterface $form, $data): Response
    {
        $this->params['form'] = $form->createView();
        return  $this->supports()->redirectToRoute($this->template, $this->params);
    }

    public function onRender(FormInterface $form, $data): Response
    {
        $this->params['form'] = $form->createView();
        return  $this->supports()->render($this->template, $this->params);
    }


    /**
     * @return bool|mixed
     * @throws \Exception
     */
    private function supports(): self
    {
        return (!$this->isInitialize)? throw new \Exception('You must call first method initialize(string $template, array $params=[])'): true;
    }


//    public function renderTemplate(string $template, array $params)
//    {
//        $this->supports();
//        $content = $this->twig->render($this->template, $this->params);
//        $response = new Response();
//        $response->setContent($content);
//
//        return $response;
//    }
//
//
//    public function redirectToRoute(string $template, array $params)
//    {
//        $this->supports();
//        $content = $this->twig->render($this->template, array_merge($this->params));
//        $response = new Response();
//        $response->setContent($content);
//
//        return $response;
//    }

}