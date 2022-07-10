<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category')]
class CategoryController extends AbstractApiController
{
    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->respond($categoryRepository->findAll());
    }

    #[Route('/new', name: 'app_category_new', methods: ['POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $form = $this->buildForm(CategoryType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * @var Category $category
         */
        $category = $form->getData();
        $category->setCreatedAt(new DateTime());
        $category->setUpdatedAt(new DateTime());
        $categoryRepository->add($category, true);

        return $this->json($category, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->respond($category, Response::HTTP_OK);
    }

    #[Route('/{id}/update', name: 'app_category_edit', methods: ['PUT'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->buildForm(CategoryType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /**
         * @var Category $category
         */
        $category = $form->getData();
        $category->setUpdatedAt(new DateTime());
        $categoryRepository->add($category, true);

        return $this->respond($category, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Category $category, CategoryRepository $categoryRepository): Response
    {
        $categoryRepository->remove($category);

        return $this->respond([], Response::HTTP_NO_CONTENT);
    }
}
