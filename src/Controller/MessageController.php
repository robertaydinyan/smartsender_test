<?php

namespace App\Controller;

use App\Constants\FormOptions;
use App\Entity\MessageHistory;
use App\Form\MessageHistoryType;
use App\Repository\MessageHistoryRepository;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    #[Route('/', name: 'app_message_index', methods: ['GET'])]
    public function index(MessageHistoryRepository $messageHistoryRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'message_histories' => $messageHistoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MessageService $messageService): Response
    {
        $messageHistory = new MessageHistory();
        $form = $this->createForm(MessageHistoryType::class, $messageHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $channel = $messageHistory->getChannel();
            if ($messageHistory->getType()) {
                $method = ucfirst(FormOptions::MESSAGE_OPTIONS[$messageHistory->getType()]);
                if ($channel->getEnabled() && $channel->{"get" . $method}()) {
                    $entityManager->persist($messageHistory);
                    $entityManager->flush();
                    $messageService->send(
                        $channel->getCustomers(),
                        FormOptions::MESSAGE_OPTIONS[$messageHistory->getType()],
                        $messageHistory->getTitle(),
                        $messageHistory->getMessage()
                    );

                    return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
                }
            }
            $this->addFlash('error', 'Channel doesnt allow to send message like that');
        }

        return $this->render('message/new.html.twig', [
            'message_history' => $messageHistory,
            'form' => $form,
        ]);
    }
}
