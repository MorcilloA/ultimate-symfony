<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function renderMenuList()
    {
        // 1. Aller chercher les catégories dans la base de données (repository)
        $categories = $this->categoryRepository->findAll();

        // 2. Renvoyer le rendu HTML sous la forme d'une Response ($this->render)
        return $this->render("category/_menu.html.twig", [
            "categories" => $categories
        ]);
    }

    /**
     * @Route("/category", name="category")
     */
    // public function index(): Response
    // {
    //     return $this->render('category/index.html.twig', [
    //         'controller_name' => 'CategoryController',
    //     ]);
    // }

    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $category = new Category;

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category->setSlug(strtolower($slugger->slug($category->getName())));

            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute("homepage");
        }

        return $this->render("category/create.html.twig", [
            "formView" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="category_edit")
     */
    public function edit($id, CategoryRepository $categoryRepository, Request $request, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $category = $categoryRepository->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug(strtolower($slugger->slug($category->getName())));

            $em->flush();

            return $this->redirectToRoute("homepage");
        }

        return $this->render("category/edit.html.twig", [
            "category" => $category,
            "formView" => $form->createView()
        ]);
    }
}
