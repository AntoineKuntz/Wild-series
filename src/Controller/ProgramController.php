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
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();


    return $this->render('program/index.html.twig',['programs' => $programs]);
    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(int $id):Response

{

    $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id]);

        $seasons = $this->getDoctrine()->getRepository(Season::class)->findBy(['program' => $program]);

    if (!$program) {

        throw $this->createNotFoundException('No program with id : '.$id.' found in program\'s table.');

    }

    return $this->render('program/show.html.twig', ['program' => $program,'seasons' => $seasons]);
}


    /**
     * @Route("/{programId}/seasons/{seasonId}",methods={"GET"}, name="seasonShow")
     */
public function showSeason( $programId, $seasonId)
    {
        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $programId]);

        $seasons = $program->getSeason();

        $season = $this->getDoctrine()->getRepository(Season::class)->findOneBy(['id' => $seasonId]);

        /*$episodes = $season->getEpisodes(); */

        $episode = $this->getDoctrine()->getRepository(Episode::class)->findBy(['season' => $seasonId]);

        

        if (!$program) {
            throw $this->createNotFoundException('No program with id : ' . $programId . ' found in program\'s table.');
        }
        return $this->render('program/season_show.html.twig', ['program' => $program,'season' => $season]);
    }
}