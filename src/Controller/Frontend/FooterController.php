<?php

namespace App\Controller\Frontend;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooterController extends AbstractController
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/contact', name: 'footer_contact')]
    public function contact(): Response
    {
        $this->logger->info('Contact page accessed');
        return $this->render('Footer/contact.html.twig');
    }

    #[Route('/mentions-legales', name: 'footer_mentions_legales')]
    public function mentionsLegales(): Response
    {
        $this->logger->info('Mentions légales page accessed');
        return $this->render('Footer/mentions_legales.html.twig');
    }

    #[Route('/copyright', name: 'footer_copyright')]
    public function copyright(): Response
    {
        $this->logger->info('Copyright page accessed');
        return $this->render('Footer/copyrights.html.twig');
    }

    #[Route('/credits', name: 'footer_credits')]
    public function credits(): Response
    {
        $this->logger->info('Credits page accessed');
        return $this->render('Footer/credits.html.twig');
    }

    #[Route('/conditions-generales', name: 'footer_conditions_generales')]
    public function conditionsGenerales(): Response
    {
        $this->logger->info('Conditions générales page accessed');
        return $this->render('Footer/conditions_generales.html.twig');
    }
}
