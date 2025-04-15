<?php

namespace CleverAge\SyliusColissimoPlugin\Controller\Admin;

use CleverAge\SyliusColissimoPlugin\Controller\ActionInterface;
use CleverAge\SyliusColissimoPlugin\Entity\ColissimoParameter;
use CleverAge\SyliusColissimoPlugin\Event\ColissimoParameterCredentialsHasherEvent;
use CleverAge\SyliusColissimoPlugin\Form\Type\ColissimoParameterType;
use CleverAge\SyliusColissimoPlugin\Repository\ColissimoParameterRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

final class UpdateColissimoParameterAction implements ActionInterface
{
    public function __construct(
        private EntityManagerInterface $manager,
        private Environment $templatingEngine,
        private ColissimoParameterRepositoryInterface $colissimoParameterRepository,
        private FormFactoryInterface $formFactory,
        private EventDispatcherInterface $dispatcher,
        private RequestStack $requestStack,
        private TranslatorInterface $translator,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if (!$colissimoParameter = $this->colissimoParameterRepository->get()) {
            $colissimoParameter = (new ColissimoParameter())->setId(1);

            $this->manager->persist($colissimoParameter);
            $this->manager->flush();
        }

        $form = $this->formFactory
            ->create(ColissimoParameterType::class, $colissimoParameter)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatcher->dispatch(new ColissimoParameterCredentialsHasherEvent($colissimoParameter));

            $this->requestStack->getMainRequest()->getSession()->getFlashBag()->add(
                'success',
                $this->translator->trans('clever_age.admin.ui.colissimo_parameter.success'),
            );

            $this->manager->flush();
        }

        return new Response(
            $this->templatingEngine->render(
                '@CleverAgeSyliusColissimoPlugin/Controller/Action/colissimo_parameter.html.twig',
                [
                    'form' => $form->createView(),
                ],
            )
        );
    }
}
