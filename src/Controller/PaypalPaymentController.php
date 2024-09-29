<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaypalPaymentController extends AbstractController
{
    #[Route('/paypal/payment', name: 'app_paypal_payment')]
    public function ui(): string
    {
       
    }



}
