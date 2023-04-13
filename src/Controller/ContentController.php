<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContentType;
use App\Entity\Content;
use App\Entity\ContentParameter;
use App\Entity\Menu;
use App\Entity\ParameterValue;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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

    #[Route('/content/page/{slug}', name: 'show_slug')]
    public function showSlug($slug)
    {
        $content = $this->em->getRepository(Content::class)->findOneBy(['slug' => $slug]);
        if(!$content) {
            throw new Exception("Error Processing Request", 1);
        }

        $menu = $this->em->getRepository(Menu::class)->findAll();

        $contentToReturn = [];
        foreach($content->getContentParameters() as $contentParameter) {
            foreach($contentParameter->getParameterValues() as $contentParameterValue) {
                if($contentParameterValue->getSectionParameterType() == "3") {
                    $contentToReturn[$contentParameter->getId()][$contentParameter->getSectionType()]['numberHeading'] = $contentParameterValue->getValue();
                } elseif ($contentParameterValue->getSectionParameterType() == "1") {
                    $contentToReturn[$contentParameter->getId()][$contentParameter->getSectionType()]['value'] = $contentParameterValue->getValue();
                }
            }
        }

        $template = $content->getTemplate();
        return $this->render('/public/'.$template. '/'.$template.'/inner-page.html.twig', ['content' => $contentToReturn, 'menu' => $menu]);

    }

    #[Route('/content/show/{id}', name: 'app_content_show')]
    public function show($id)
    {
        $content = $this->em->getRepository(Content::class)->find($id);
        $contentParametersToReturn = [];
        foreach($content->getContentParameters() as $key => $value) {
            $parametersValues = [];
            foreach($value->getParameterValues() as $key => $v) {
                $parametersValues []= [
                    'value' => $v->getValue(),
                    'sectionParameterType' => array_flip(Content::PARAMETER_TYPES)[$v->getSectionParameterType()]
                ];
            }
            $contentParametersToReturn []= [
                'type' => $value->getSectionType(),
                'code' => $value->getCode(),
                'values' => $parametersValues,
                Content::SECTION_PARAMETERS_TYPES[$value->getType()]
            ];

            
        }
        $contentReturn = [
            'name' => $content->getName(),
            'code' => $content->getCode(),
            'slug' => $content->getSlug(),
            'contentParameters' => $contentParametersToReturn
        ];

        return new JsonResponse(
            [
                'response' => $this->render('content/show.html.twig', ['content' => $contentReturn])->getContent()
            ]
        );
    }

    #[Route('/content/create', name: 'app_content_create')]
    public function create(Request $request)
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contentParameters = $request->get('content')['contentParameters'];
            foreach($contentParameters as $parameter) {
                $contentParameter = new ContentParameter();
                $contentParameter->setCode($parameter['code']);
                $contentParameter->setType($parameter['type']);
                $contentParameter->setSectionType(array_flip(Content::SECTION_TYPES)[$parameter['type']]);
                if(array_key_exists('heading', $parameter) && array_key_exists('text', $parameter) && !empty($parameter['heading']) && !empty($parameter['text'])) {
                    $parameterValue1 = new ParameterValue();
                    $parameterValue1->setValue($parameter['heading']);
                    $parameterValue1->setSectionParameterType(Content::PARAMETER_TYPES['number']);
                    $contentParameter->addParameterValue($parameterValue1);
                    $parameterValue2 = new ParameterValue();
                    $parameterValue2->setValue($parameter['text']);
                    $parameterValue2->setSectionParameterType(Content::PARAMETER_TYPES['text']);
                    $contentParameter->addParameterValue($parameterValue2);
                } else {
                    $parameterValue = new ParameterValue();
                    $parameterValue->setValue($parameter['text']);
                    $parameterValue->setSectionParameterType(Content::PARAMETER_TYPES['text']);
                    $contentParameter->addParameterValue($parameterValue);
                }
                
                $content->addContentParameter($contentParameter);
                $this->em->persist($contentParameter);
            }
            $slugify = new Slugify();
            $content->setSlug($slugify->slugify($content->getName(), '-'));
            $this->em->persist($content);

            if($request->get('content')['template'] != 4) {
                $content->setTemplate(array_flip(Content::TEMPLATES)[$request->get('content')['template']]);
            }

            if(isset($request->get('content')['menu']) && $request->get('content')['menu']) {
                $menu = new Menu();
                $menu->setName($content->getId() . ' - '.strtok($content->getName(), ' ')[0]);
                $menu->setPath($this->generateUrl('show_slug', ['slug' => $content->getSlug()]));
                $this->em->persist($menu);
            }
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

    #[Route('/content/delete/{id}', name: 'app_content_delete')]
    public function delete(Request $request, $id)
    {
        $content = $this->em->getRepository(Content::class)->find($id);
$this->em->remove($content);
$this->em->flush();
return $this->redirectToRoute('app_content');
    }
}
