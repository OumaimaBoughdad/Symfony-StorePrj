<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use App\Entity\Products;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProductsRepository $productRepository): Response
    {
        // Retrieve the authenticated user (if any)
        $user = $this->getUser();
        //dd($user);
        // Retrieve the cart data from the session
        $panier = $session->get('panier', []);
        $data = [];
        $total = 0;
        
        // Loop through each product in the cart and retrieve its details
        foreach ($panier as $id => $quantity) {
            $product = $productRepository->find($id);
        
            // Check if the product exists before adding it to the data array
            if ($product) {
                $data[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
                $total += $product->getPrice() * $quantity;
            }
        }
        
        $photo_url = 'http://127.0.0.1:8000/uploads/';

        // Render the cart view with the cart data
        return $this->render('cart/index.html.twig', compact('data', 'total', 'photo_url'));
    }

    #[Route('/add/{id}', name: 'cart_add')]
    public function add(Products $product, SessionInterface $session): Response
    {
        // Get the product ID
        $id = $product->getId();

        // Retrieve the cart data from the session
        $panier = $session->get('panier', []);

        // Update the quantity of the product in the cart
        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        // Save the updated cart data back to the session
        $session->set('panier', $panier);

        // Redirect to the cart page
        return $this->redirectToRoute('panier');
    }
}
