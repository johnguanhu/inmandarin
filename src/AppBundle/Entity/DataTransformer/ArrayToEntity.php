<?php


namespace AppBundle\Entity\DataTransformer;


use AppBundle\Entity\Word;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArrayToEntity implements DataTransformerInterface
{

    /**
    * @var EntityManager
    */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function transform($word)
    {

        dump($word);die;

        $newArray = array();

        if (!($word instanceof PersistentCollection)) {
            return new ArrayCollection();
        }

        foreach ($word as $key => $value) {
            $newArray[] = $value;
        }

        return new ArrayCollection($newArray);
    }


    public function reverseTransform($word)
    {

        $newArray = array();

        if (!$word) {
            return new ArrayCollection();
        }

        foreach ($word as $key => $value) {
            $item = $this->em
                ->getRepository('AppBundle::Word')
                ->findOneBy(array('id' => $value))
            ;

            if (null !== ($item)) {
                $newArray[$key] = $item;
            }
        }

        return new PersistentCollection($this->em, 'AppBundle::Word', new ArrayCollection($newArray));
    }

}