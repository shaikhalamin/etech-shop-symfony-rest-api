<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryFilterRepository;
use App\Repository\CategoryRepository;
use App\Entity\CategoryFilter;
use App\Form\CategoryFilterType;
use DateTime;

#[Route('/api/category/filter')]
class CategoryFilterController extends AbstractApiController
{
    #[Route('/list', name: 'app_category_filter_index', methods: ['GET'])]
    public function index(CategoryFilterRepository $categoryFilterRepository): Response
    {
        return $this->respond($categoryFilterRepository->findAll());
    }

    #[Route('/new', name: 'app_category_filter_new', methods: ['POST'])]
    public function new(Request $request, CategoryFilterRepository $categoryFilterRepository, CategoryRepository $categoryRepository): Response
    {
        $form = $this->buildForm(CategoryFilterType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * @var CategoryFilter $categoryFilter
         */
        $categoryFilter = $form->getData();
        $categoryFilter->setCreatedAt(new DateTime());
        $categoryFilter->setUpdatedAt(new DateTime());

        $categoryFilterRepository->add($categoryFilter, true);

        return $this->respond($categoryFilter, Response::HTTP_CREATED); 
    }

    #[Route('/{id}', name: 'app_category_filter_show', methods: ['GET'])]
    public function show(CategoryFilter $categoryFilter): Response
    {
        return $this->respond($categoryFilter, Response::HTTP_OK);
    }

    #[Route('/{id}/edit', name: 'app_category_filter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryFilter $categoryFilter, CategoryFilterRepository $categoryFilterRepository): Response
    {
        $form = $this->createForm(CategoryFilterType::class, $categoryFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryFilterRepository->add($categoryFilter, true);

            return $this->redirectToRoute('app_category_filter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_filter/edit.html.twig', [
            'category_filter' => $categoryFilter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_filter_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryFilter $categoryFilter, CategoryFilterRepository $categoryFilterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryFilter->getId(), $request->request->get('_token'))) {
            $categoryFilterRepository->remove($categoryFilter, true);
        }

        return $this->redirectToRoute('app_category_filter_index', [], Response::HTTP_SEE_OTHER);
    }
}
