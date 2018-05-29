<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use AppBundle\Form\WordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

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
            'form' => $form->createView()
        ]);

    }

    public function searchAction()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
//            ->add('language', ChoiceType::class, array(
//                'choices'  => array(
//                    'Please select language' => '',
//                    'English' => 'en',
//                    'Chinese' => 'zh',
//                ),
//            ))
            ->add('translate', SubmitType::class, array('label' => 'Translate'))
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
//        $language = $request->request->get('form')['language'];

        $detector = $this->get('eko.google_translate.detector');
        $translator = $this->get('eko.google_translate.translator');
        $language = $detector->detect($search);

        if (!$search && !$language) {
            throw new NotFoundHttpException('Incorrect Data');
        }
        $words = $repository->findByWord($search);
        $entityManager = $this->getDoctrine()->getManager();

        if(!$words){
            $word = new Word();
            $translation = new Word();
            if($language === 'en'){
                $word->setWord($search);
                $word->setLanguage($language);

                $translation->setWord(strtolower($translator->translate($search, 'zh-CN', $language)));
                $translation->setLanguage('zh-CN');

                $word->addMyTranslation($translation);
            }else{
                $word->setWord($search);
                $word->setLanguage($language);

                $translation->setWord(strtolower($translator->translate($search, 'en', $language)));
                $translation->setLanguage('en');

                $word->addMyTranslation($translation);
            }
//            $entityManager->persist($word);
//            $entityManager->flush();

            $words[] = $word;
        }

        return $this->render('@App/index/index.html.twig', array(
            'words' => $words,
        ));
    }

    /**
     * @Route("/confirm", name="confirm")
     */
    public function confirmAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Word');

        $word_string = $request->query->get('word');
        $word_lang = $request->query->get('word_lang');
        $trans_word = $request->query->get('word_trans');
        $trans_lang = $request->query->get('trans_lang');

        if (!$word_string && !$word_lang && !$trans_word && !$trans_lang) {
            throw new NotFoundHttpException('Incorrect Data');
        }
        $entityManager = $this->getDoctrine()->getManager();

        $word = new Word();
        $translation = new Word();

        $word->setWord($word_string);
        $word->setLanguage($word_lang);
        $word->setConfirmed(1);

        $translation->setWord($trans_word);
        $translation->setLanguage($trans_lang);
        $translation->setConfirmed(1);

        $word->addMyTranslation($translation);

        $entityManager->persist($word);
        $entityManager->flush();

        $this->addFlash('success', 'Translation was successfully confirmed');

        return $this->redirect($this->generateUrl('homepage', [
//            'id' => $word->getId()
        ]));
    }


    /**
     * @Route("/edit", name="edit")
     */
    public function editAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Word');

        $word = $repository->findOneById($request->get('id'));

        if (!$word) {
            throw new NotFoundHttpException('No Word found!');
        }

        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($word);
            $entityManager->flush();

            $this->addFlash('success', 'Word was succesfuly edited');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('@App/index/form.html.twig', [
            'word' => $word,
            'form' => $form->createView(),
        ]);

    }

}