<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class CategoryController extends AbstractController
{
    private $categoryRepository;
    private $entityManager;


    public function __construct(
        CategoryRepository $categoryRepository,
        ManagerRegistry $doctrine) 
    {
       
        $this->categoryRepository=$categoryRepository;
        $this->entityManager=$doctrine->getManager();
    }


    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    #[Route('/store/product', name: 'product_store')]
    public function store(Request $request): Response // Use correct Request class
    {
        $product = new Category();
        $form = $this->createForm(CategoryType::class,$product);
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                $product = $form->getData();
                if($request->files->get('product')['image']){
                    $image = $request->files->get('product')['image'];
                    $image_name= time().'_'.$image->getClientOriginalName();
                    $image->move($this->getParameter('image_directory'),$image_name);
                    $product->setImage($image_name);
                }
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $this->addFlash('success','Your product was added ');
                return $this->redirectToRoute('product_list');
         }
        return $this->renderForm('product/create.html.twig', [
            'form' => $form,
        ]);
    }




}
