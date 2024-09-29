<?php

namespace App\Controller;
use App\Entity\Products;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request; // Import correct
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $productRepository;
    private $entityManager;
    public function __construct(
        ProductsRepository $productsRepository ,ManagerRegistry $doctrine) 
    {
        $this->productRepository=$productsRepository;
        $this->entityManager=$doctrine->getManager();
    }
    #[Route('/product', name: 'product_list')]
    /**
     *  @IsGranted("ROLE_ADMIN", statusCode =404 ,message="Page not autorizied")
     */
    public function index(): Response
    {
        $products=$this->productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     *  @IsGranted("ROLE_ADMIN", statusCode =404 ,message="Page not autorizied")
     */
    #[Route('/store/product', name: 'product_store')]
    public function store(Request $request): Response // Use correct Request class
    {
        $product = new Products();
        $form = $this->createForm(ProductType::class,$product);
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
    //show function
    /**
     *  @IsGranted("ROLE_ADMIN", statusCode =404 ,message="Page not autorizied")
     */
     #[Route('/product/details/{id}', name: 'product_show')]
    public function show(Products $product): Response
    {
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'photo_url' => 'http://127.0.0.1:8000/uploads/'
        ]);
    }
    //ajouter au panier

    #[Route('/product/panier/{id}', name: 'product_ajouter')]
    public function ajouter(Products $product): Response
    {
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'photo_url' => 'http://127.0.0.1:8000/uploads/'
        ]);
    }

    //edit function
    #[Route('/product/edit/{id}',name:'product_edit')]
    /**
     *  @IsGranted("ROLE_ADMIN", statusCode =404 ,message="Page not autorizied")
     */
    public function edit(Request $request,$id):Response{
        $product =$this->productRepository->find($id);
        $form = $this->createForm(ProductType::class,$product);
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
                $this->addFlash('success',
                'Your product was updated'
                );
                return $this->redirectToRoute('product_list');
         }
        return $this->renderForm('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product_delete')]
    /**
     *  @IsGranted("ROLE_ADMIN", statusCode =404 ,message="Page not autorizied")
     */   
    public function delete(Products $product): Response
    {
        $filesystem = new Filesystem(); 
        $imagePath = './uploads/'.$product->getImage();
        if($filesystem->exists($imagePath)){
            $filesystem->remove($imagePath);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $this->entityManager->remove($product);

        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            'Your product was removed'
        );
        return $this->redirectToRoute('product_list');
    }

}
