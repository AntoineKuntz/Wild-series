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

 /**
     * @Route("/programs/", name="program_")
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
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
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
     * @Route("/{program}/seasons/{season}/episode/{episode}", name="episode_show")
     * @return Response
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', ['program' => $program,'season' => $season,'episode' => $episode,]);
    }

}
