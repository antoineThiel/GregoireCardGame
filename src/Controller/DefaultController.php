<?php


namespace App\Controller;

use App\Entity\Deck;
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
        $decks = $deckRepository->findBy(["isPool" => false, "isCemetery" => false]);
        foreach ($decks as $deck){
            if ($deck->getCemetery() == null and $deck->getPool() == null) {
                $currentPool = new Deck();
                $currentPool->setIsPool(true);
                $currentPool->setTitle("Current pool");
                $currentPool->setCards($deck->getCard());
                $cemetery = new Deck();
                $cemetery->setTitle("Cemetery");
                $cemetery->setIsCemetery(true);
                $deck->setPool($currentPool);
                $deck->setCemetery($cemetery);
                $entityManager->persist($deck);
            }
        }
        $entityManager->flush();
        return $this->render('game.html.twig', [
            "decks" => $decks
        ]);
    }

    /**
     * @Route("/game", name="game")
     */
    public function game(DeckRepository $deckRepository, EntityManagerInterface $entityManager){
        $decks = $deckRepository->findBy(["isCemetery" => false, "isPool" => false]);
        return $this->render('game.html.twig', [
            "decks" => $decks
        ]);
    }

    /**
     * @Route("/draw/{deck}", name="draw")
     * @param Request $request
     * @return Response
     */
    public function drawCard(Request $request, DeckRepository $deckRepository , EntityManagerInterface $entityManager,Deck $deck)
    {
        $decks = $deckRepository->findBy(["isCemetery" => false, "isPool" => false]);
        $maxRandom = count($deck->getPool()->getCard()) - 1;
        if ($maxRandom < 0) {
            return $this->render('game.html.twig', [
                "decks" => $decks,
            ]);
        }
        $cardNbre = rand(0, $maxRandom);
        $card = $deck->getPool()->getCard()[$cardNbre];
        $deck->getPool()->removeCard($card);
        $deck->getCemetery()->addCard($card);
        $entityManager->persist($deck);
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
    public function reset(DeckRepository $deckRepository, EntityManagerInterface $entityManager)
    {
        $decks = $deckRepository->findBy(["isPool" => false, "isCemetery" => false]);
        foreach ($decks as $deck){
            $cemetery = $deck->getCemetery();
            $pool = $deck->getPool();
            if ($cemetery) {
                $deck->setCemetery(null);
                $entityManager->remove($cemetery);
            }
            if ($pool) {
                $deck->setPool(null);
                $entityManager->remove($pool);
            }
        }
        $entityManager->flush();
        return $this->render('homepage.html.twig', []);
    }







}