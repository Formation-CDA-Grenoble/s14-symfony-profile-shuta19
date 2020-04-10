<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show")
     */
    public function show(Category $category)
    {
        return $this->render('category/single.html.twig', [
            'category' => $category,
            'articles' => $category->getArticles()
        ]);
    }
}
