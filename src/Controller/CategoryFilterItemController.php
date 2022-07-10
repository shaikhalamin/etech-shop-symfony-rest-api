<?php

namespace App\Controller;

use App\Entity\CategoryFilterItem;
use App\Form\CategoryFilterItemType;
use App\Repository\CategoryFilterItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category/filter/item')]
class CategoryFilterItemController extends AbstractController
{
    #[Route('/', name: 'app_category_filter_item_index', methods: ['GET'])]
    public function index(CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        return $this->render('category_filter_item/index.html.twig', [
            'category_filter_items' => $categoryFilterItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_filter_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        $categoryFilterItem = new CategoryFilterItem();
        $form = $this->createForm(CategoryFilterItemType::class, $categoryFilterItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryFilterItemRepository->add($categoryFilterItem, true);

            return $this->redirectToRoute('app_category_filter_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_filter_item/new.html.twig', [
            'category_filter_item' => $categoryFilterItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_filter_item_show', methods: ['GET'])]
    public function show(CategoryFilterItem $categoryFilterItem): Response
    {
        return $this->render('category_filter_item/show.html.twig', [
            'category_filter_item' => $categoryFilterItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_filter_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryFilterItem $categoryFilterItem, CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        $form = $this->createForm(CategoryFilterItemType::class, $categoryFilterItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryFilterItemRepository->add($categoryFilterItem, true);

            return $this->redirectToRoute('app_category_filter_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_filter_item/edit.html.twig', [
            'category_filter_item' => $categoryFilterItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_filter_item_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryFilterItem $categoryFilterItem, CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryFilterItem->getId(), $request->request->get('_token'))) {
            $categoryFilterItemRepository->remove($categoryFilterItem, true);
        }

        return $this->redirectToRoute('app_category_filter_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
