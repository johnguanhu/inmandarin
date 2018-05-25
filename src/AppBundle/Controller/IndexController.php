<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use AppBundle\Form\WordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        $words = $this->getDoctrine()
//            ->getRepository('AppBundle:Word')
//            ->findAll();

        return $this->render('@App/index/index.html.twig', array(
//            'words' => $words,
        ));
    }

    /**
     * @Route("/add", name="add_word")
     */
    public function createAction(Request $request)
    {
        $word = new Word();

        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($word);
            $entityManager->flush();

            $this->addFlash('success', 'New word was succesfully created');

            return $this->redirect($this->generateUrl('homepage', [
                'id' => $word->getId()
            ]));
        }

        return $this->render('@App/index/form.html.twig', [
            'word' => $word,
            'form' => $form->createView(),
            'action' => $this->generateUrl('translate'),
            'method' => 'POST',
        ]);

    }

    public function searchAction()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/index/search.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="handleSearch")
     */
    public function handleSearch(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Word');

        $search = $request->request->get('form')['search'];

        if ($search) {
            $words = $repository->findByWord($search);
        } else {
            $words = $repository->findAll();
        }

        return $this->render('@App/index/index.html.twig', array(
            'words' => $words,
        ));
    }

    /**
     * @Route("/translate", name="translate")
     */
    public function translateAction(Request $request)
    {
        $langFrom = $request->get('language');
        $word = $request->get('word');

        if($langFrom === 'en'){
            $translation = $this->get('pryon.google.translator')->translate('en','zh', $word);
        }else{
            $translation = $this->get('pryon.google.translator')->translate('zh','en', $word);
        }

        $data = [
            'status'=>'ok',
            'translation'=> $translation
        ];

        return new JsonResponse($data);
    }
}