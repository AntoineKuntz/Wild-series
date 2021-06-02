<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * Show all rows from Category’s entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categories' => $categories]
        );
    }

    /**
     * The controller for the category add form
     * Correspond à la route /categories/new et au name "category_new"
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Render the form
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()&& $form->isValid()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    /**
     * Getting a program by category
     *
     * @Route("/{cat}", name="name")
     * @return Response
     */

    public function showCat(string $cat): Response
    {

        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name' => $cat]);


        $programs = $category->getPrograms();


        return $this->render('category/show.html.twig', [
            'programs' => $programs,
        ]);
    }
}

