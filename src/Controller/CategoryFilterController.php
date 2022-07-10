<?php

namespace App\Controller;

use App\Entity\CategoryFilter;
use App\Form\CategoryFilterType;
use App\Repository\CategoryFilterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category/filter')]
class CategoryFilterController extends AbstractController
{
    #[Route('/', name: 'app_category_filter_index', methods: ['GET'])]
    public function index(CategoryFilterRepository $categoryFilterRepository): Response
    {
        return $this->render('category_filter/index.html.twig', [
            'category_filters' => $categoryFilterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_filter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryFilterRepository $categoryFilterRepository): Response
    {
        $categoryFilter = new CategoryFilter();
        $form = $this->createForm(CategoryFilterType::class, $categoryFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryFilterRepository->add($categoryFilter, true);

            return $this->redirectToRoute('app_category_filter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_filter/new.html.twig', [
            'category_filter' => $categoryFilter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_filter_show', methods: ['GET'])]
    public function show(CategoryFilter $categoryFilter): Response
    {
        return $this->render('category_filter/show.html.twig', [
            'category_filter' => $categoryFilter,
        ]);
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
