<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use AppBundle\Form\WordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $words = $this->getDoctrine()
            ->getRepository('AppBundle:Word')
            ->findAll();


        return $this->render('@App/index/index.html.twig', array(
            'words' => $words,
        ));
    }

    /**
     * @Route("/add", name="add_word")
     */
    public function createAction(Request $request)
    {

        $word = new Word();

//        $word->setWord('love');
//        $word->setDescription('love');
//        $word->setLanguage('love');

//        $word2 = new Word();

//        $word2->setWord('hate');
//        $word2->setDescription('hate');
//        $word2->setLanguage('hate');
//        $word->addMyTranslation($word2);


//        $entityManager = $this->getDoctrine()->getManager();
//
//        dump($word);
//
//        $entityManager->persist($word);
//        $entityManager->flush();


        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

//            $word2 = new Word();
//
//            $word2->setWord($word->getMyTranslation()->toArray()['word']);
//            $word2->setDescription($word->getMyTranslation()->toArray()['description']);
//            $word2->setLanguage($word->getMyTranslation()->toArray()['language']);
//
//
//            $word->clearTransaction();
//
//            $word->addMyTranslation($word2);

//            var_dump($word);

            $entityManager->persist($word);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('homepage', [
                'id' => $word->getId()
            ]));
        }

        return $this->render('@App/index/form.html.twig', [
            'word' => $word,
            'form' => $form->createView(),
        ]);

    }
}