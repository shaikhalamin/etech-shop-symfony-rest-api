<?php

namespace App\Controller;

use App\Entity\CategoryFilterItem;
use App\Form\CategoryFilterItemType;
use App\Repository\CategoryFilterItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/api/category/filter/item')]
class CategoryFilterItemController extends AbstractApiController
{
    #[Route('/list', name: 'app_category_filter_item_index', methods: ['GET'])]
    public function index(CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        return $this->respond($categoryFilterItemRepository->findAll());
    }

    #[Route('/new', name: 'app_category_filter_item_new', methods: ['POST'])]
    public function new(Request $request, CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        $form = $this->buildForm(CategoryFilterItemType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * @var CategoryFilterItem $categoryFilterItem
         */
        $categoryFilterItem = $form->getData();
        $categoryFilterItem->setCreatedAt(new DateTime());
        $categoryFilterItem->setUpdatedAt(new DateTime());
        $categoryFilterItemRepository->add($categoryFilterItem, true);

        return $this->respond($categoryFilterItem, Response::HTTP_CREATED);
    }

    #[Route('/details/{id}', name: 'app_category_filter_item_show', methods: ['GET'])]
    public function show(CategoryFilterItem $categoryFilterItem): Response
    {
        return $this->respond($categoryFilterItem, Response::HTTP_OK);
    }

    #[Route('/update/{id}', name: 'app_category_filter_item_edit', methods: ['POST'])]
    public function edit(Request $request, CategoryFilterItem $categoryFilterItem, CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        $form = $this->buildForm(CategoryFilterItemType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * @var CategoryFilterItem $categoryFilterItem
         */
        $categoryFilterItem = $form->getData();
        $categoryFilterItem->setUpdatedAt(new DateTime());
        $categoryFilterItemRepository->add($categoryFilterItem, true);

        return $this->respond($categoryFilterItem, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_category_filter_item_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryFilterItem $categoryFilterItem, CategoryFilterItemRepository $categoryFilterItemRepository): Response
    {
        $categoryFilterItemRepository->remove($categoryFilterItem);

        return $this->respond([], Response::HTTP_NO_CONTENT);
    }
}
