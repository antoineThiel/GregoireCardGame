<?php

namespace App\Controller;

use App\Entity\Cemetery;
use App\Entity\Deck;
use App\Entity\Pool;
use App\Form\DeckType;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/deck')]
class DeckController extends AbstractController
{
    #[Route('/', name: 'app_deck_index', methods: ['GET'])]
    public function index(DeckRepository $deckRepository): Response
    {
        return $this->render('deck/index.html.twig', [
            'decks' => $deckRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_deck_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DeckRepository $deckRepository, EntityManagerInterface $entityManager): Response
    {
        $deck = new Deck();
        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deckRepository->add($deck);
            $cemetery = new Cemetery();
            $cemetery->setDeck($deck);
            $deck->setCemetery($cemetery);
            $pool = new Pool();
            $pool->setDeck($deck);
            $deck->setPool($pool);
            $entityManager->persist($cemetery);
            $entityManager->persist($pool);
            $entityManager->flush();
            return $this->redirectToRoute('app_deck_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deck/new.html.twig', [
            'deck' => $deck,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deck_show', methods: ['GET'])]
    public function show(Deck $deck): Response
    {
        return $this->render('deck/show.html.twig', [
            'deck' => $deck,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_deck_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Deck $deck, DeckRepository $deckRepository): Response
    {
        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deckRepository->add($deck);
            return $this->redirectToRoute('app_deck_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deck/edit.html.twig', [
            'deck' => $deck,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deck_delete', methods: ['POST'])]
    public function delete(Request $request, Deck $deck, DeckRepository $deckRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deck->getId(), $request->request->get('_token'))) {
            $deckRepository->remove($deck);
        }

        return $this->redirectToRoute('app_deck_index', [], Response::HTTP_SEE_OTHER);
    }
}
