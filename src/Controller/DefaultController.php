<?php


namespace App\Controller;

use App\Entity\Deck;
use App\Repository\CardRepository;
use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @Route("/")
 */
class DefaultController extends AbstractController
{

    /**
     * @Route("/newGame", name="newgame")
     */
    public function newGame(DeckRepository $deckRepository, EntityManagerInterface $entityManager){
        $decks = $deckRepository->findAll();
        return $this->render('game.html.twig', [
            "decks" => $decks
        ]);
    }

    /**
     * @Route("/game", name="game")
     */
    public function game(DeckRepository $deckRepository, EntityManagerInterface $entityManager){
        $decks = $deckRepository->findAll();
        return $this->render('game.html.twig', [
            "decks" => $decks
        ]);
    }

    /**
     * @Route("/draw/{deck}", name="draw")
     * @param Request $request
     * @return Response
     */
    public function drawCard(Request $request, DeckRepository $deckRepository , EntityManagerInterface $entityManager, Deck $deck)
    {
        $decks = $deckRepository->findAll();
        $maxRandom = count($deck->getPool()->getCardsInPool()) - 1;
        if ($maxRandom < 0) {
            return $this->render('game.html.twig', [
                "decks" => $decks,
            ]);
        }
        $cardNbre = rand(0, $maxRandom);
        $card = $deck->getPool()->getCardsInPool()[$cardNbre];
        $card->setInPool(false);
        $card->setInCemetery(true);
        $entityManager->persist($card);
        $entityManager->flush();
        return $this->render('game.html.twig', [
            "decks" => $decks,
            "drawn_card" => $card
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(){
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/reset", name="reset")
     */
    public function reset(CardRepository $cardRepository, EntityManagerInterface $entityManager)
    {
        $cards = $cardRepository->findAll();
        foreach ($cards as $card)
        {
            $card->setInCemetery(false);
            $card->setInPool(true);
            $entityManager->persist($card);
        }
        $entityManager->flush();
        return $this->redirectToRoute("newgame");
    }







}