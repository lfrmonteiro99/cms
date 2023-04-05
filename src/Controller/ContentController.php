<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContentType;
use App\Entity\Content;
use App\Entity\ContentParameter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContentController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route('/content', name: 'app_content')]
    public function index()
    {
        $contents = $this->em->getRepository(Content::class)->findAll();
        return $this->render('content/index.html.twig', [
            'contents' => $contents
        ]);
    }

    #[Route('/content/show/{id}', name: 'app_content_show')]
    public function show($id)
    {
        $content = $this->em->getRepository(Content::class)->find($id);
        return new JsonResponse($content, 200); // constant for 404
    }

    #[Route('/content/create', name: 'app_content_create')]
    public function create(Request $request)
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            dump($request);
            die;
            $contentParameters = $request->get('content')['contentParameters'];
            foreach($contentParameters as $parameter) {
                $contentParameter = new ContentParameter();
                $contentParameter->setCode($parameter['code']);
                $contentParameter->setValue($parameter['value']);
                $contentParameter->setType($parameter['type']);
                $content->addContentParameter($contentParameter);
                $this->em->persist($contentParameter);
            }
            $slugify = new Slugify();
            $content->setSlug($slugify->slugify($content->getName(), '-'));
            $this->em->persist($content);
            $this->em->flush();
            return $this->redirectToRoute('app_content');
        }

        return $this->render('content/create.html.twig', [
            'form' => $form->createView(),
            'content' => $content
        ]);
    }

    #[Route('/content/edit/{id}', name: 'app_content_edit')]
    public function edit(Request $request, $id)
    {
        $content = $this->em->getRepository(Content::class)->find($id);
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $content->setSlug($slugify->slugify($content->getName(), '-'));
            $this->em->persist($content);
            $this->em->flush();
            return $this->redirectToRoute('app_content');
        }

        return $this->render('content/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
