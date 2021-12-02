<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
/**
 * @route ("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @route("/") name=("index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categories' => $categories]
        );
    }

    /**
     * @route ("/category/{categoryName}"), methods={"GET"}, name=("show")
     * @param string $categoryName
     * @return Response
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['name' => $categoryName])
            ->orderBy('c.id','DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;

        if (!$category) {
            throw $this->createNotFoundException('The category does not exist');
        }
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
