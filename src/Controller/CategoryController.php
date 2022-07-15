<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use App\Service\FileUploader;
use App\Entity\Category;
use App\Form\CategoryType;
use DateTime;

#[Route('/api/category')]
class CategoryController extends AbstractApiController
{
    const CATEGORY_IMAGE_UPLOAD_PATH = '/categories/icon/';

    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->respond($categoryRepository->findAll(), Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_category_new', methods: ['POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository, FileUploader $fileUploader): Response
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

        /** @var UploadedFile $categoryFile */
        $categoryFile = $form->get('image')->getData();

        if ($categoryFile) {
            $uploadedFileName = $fileUploader->upload($categoryFile, $category->getSlug(), self::CATEGORY_IMAGE_UPLOAD_PATH);
            $category->setImage($uploadedFileName);
        }

        $category->setCreatedAt(new DateTime());
        $category->setUpdatedAt(new DateTime());
        $categoryRepository->add($category, true);

        return $this->respond($category, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category, UrlHelper $urlHelper): Response
    {
        $categoryImagePath = $urlHelper->getAbsoluteUrl(sprintf('%s%s', $this->getParameter('images_directory'), self::CATEGORY_IMAGE_UPLOAD_PATH));
        $category->setImage(sprintf('%s%s', $categoryImagePath, $category->getImage()));
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
