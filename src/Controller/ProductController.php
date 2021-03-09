<?php

namespace App\Controller;

use App\Entity\Product;
use App\Event\ProductViewEvent;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="product_category", priority=-1)
     */
    public function category($slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy([
            "slug" => $slug
        ]);

        if (!$category) {
            // -- Sans l'AbstractController
            // throw new NotFoundHttpException("The category doesn't exist");
            // -- Avec l'AbstractController
            throw $this->createNotFoundException("La catégorie demandée n'existe pas");
        }

        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            "category" => $category
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}", name="product_show", priority=-1)
     */
    public function show($slug, ProductRepository $productRepository, EventDispatcherInterface $dispatcher)
    {
        $product = $productRepository->findOneBy([
            "slug" => $slug
        ]);

        if (!$product) {
            // -- Sans l'AbstractController
            // throw new NotFoundHttpException("The product doesn't exist");
            // -- Avec l'AbstractController
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        $productEvent = new ProductViewEvent($product);
        $dispatcher->dispatch($productEvent, 'product.view');

        return $this->render('product/show.html.twig', [
            "product" => $product
        ]);
    }

    /**
     * @Route("/admin/product/{id}/edit", name="product_edit")
     */
    public function edit($id, ProductRepository $productRepository, Request $request, EntityManagerInterface $em, SluggerInterface $slugger, ValidatorInterface $validator)
    {
        $product = $productRepository->find($id);

        $form = $this->createForm(ProductType::class, $product);

        // $form->setData($product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            dd($request);

            $product->setSlug(strtolower($slugger->slug($product->getName())));

            $em->flush();

            // $response = new Response();
            // $url = $urlGenerator->generate("product_show", [
            //     "category_slug" => $product->getCategory()->getName(),
            //     "slug" => $product->getSlug()
            // ]);
            // $response->headers->set("Location", $url);
            // $response->setStatusCode(302);

            // $response = new RedirectResponse($url);

            return $this->redirectToRoute("product_show", [
                "category_slug" => $product->getCategory()->getSlug(),
                "slug" => $product->getSlug()
            ]);
        }

        return $this->render('product/edit.html.twig', [
            "product" => $product,
            "formView" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/create", name="product_create")
     */
    public function create(FormFactoryInterface $factory, Request $request, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $product = new Product;

        // -- Sans l'AbstractController
        // $builder = $factory->createBuilder(ProductType::class);
        // $form = $builder->getForm();

        // -- Avec l'AbstractController // NE CREE QU'UN BUILDER
        // $builder = $this->createFormBuilder(ProductType::class);

        // -- Avec l'AbstractController // CREE DIRECTEMENT LE FORM
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            dd($request);
            // $product = $form->getData();

            $product->setSlug(strtolower($slugger->slug($product->getName())));

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute("product_show", [
                "category_slug" => $product->getCategory()->getSlug(),
                "slug" => $product->getSlug()
            ]);
        }

        $formView = $form->createView();

        return $this->render('product/create.html.twig', [
            "formView" => $formView
        ]);
    }
}
