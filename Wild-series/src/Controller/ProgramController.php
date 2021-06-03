<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Category;
use App\Entity\Episode;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;
 /**
     * @Route("/programs", name="program_")
     */
class ProgramController extends AbstractController
{
     /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();

        return $this->render('program/index.html.twig',['programs' => $programs]);
    }


 /**
     * The controller for the Program add form
     * Correspond à la route /Program/new et au name "program_new"
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Render the form
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        return $this->render('program/new.html.twig', ["form" => $form->createView(),]);
    }

    /**
     * Getting a program by id
     * 
     * @return Response
     * @Route("/show/{id}", name="show")
    */
    public function show(Program $program) : Response
    {

       /* $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id]);
        $season = $this->getDoctrine()->getRepository(Season::class)->findBy(['program'=>$id]);
        if (!$program) {
            throw $this->createNotFoundException('No program with id : '.$id.' found in program\'s table.');
        }*/

        return $this->render('program/show.html.twig', ['program' => $program,'seasons' => $program->getSeason()]);
    }



  /**
     * Getting a episode by season and program
     *
     * @Route("/{programId}/seasons/{seasonId}", name="seasonShow")
     * @return Response
     */
    public function showSeason(Program $programId, Season $seasonId)
    {
        $episodes = $seasonId->getEpisodes();


        return $this->render('program/season_show.html.twig', ['program' => $programId,'season' => $seasonId,'episodes' => $episodes,]);
    }

    /**
     * Getting a episode by season and program
     *
     * @Route("/{program}/seasons/{season}/episode/{episode}", name="episodeShow")
     * @return Response
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', ['program' => $program,'season' => $season,'episode' => $episode,]);
    }

}
