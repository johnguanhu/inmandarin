<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Word
 *
 * @ORM\Table(name="word")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Word
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $word;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Word", mappedBy="myTranslation", cascade={"persist"})
     */
    private $otherTranslation;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Word", inversedBy="otherTranslation", cascade={"persist"})
     * @ORM\JoinTable(name="translation",
     *     joinColumns={@ORM\JoinColumn(name="word_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="translation_word_id", referencedColumnName="id")}
     * )
     */
    private $myTranslation;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $language;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->otherTranslation = new ArrayCollection();
        $this->myTranslation = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set word
     *
     * @param string $word
     *
     * @return Word
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Word
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Word
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Add myTranslation
     *
     * @param \AppBundle\Entity\Word $myTranslation
     *
     */
    public function addMyTranslation(\AppBundle\Entity\Word $myTranslation)
    {
        $myTranslation->addOtherTranslation($this); // synchronously updating inverse side
        $this->myTranslation[] = $myTranslation;
    }

    /**
     * Remove myTranslation
     *
     * @param \AppBundle\Entity\Word $myTranslation
     */
    public function removeMyTranslation(\AppBundle\Entity\Word $myTranslation)
    {
        $this->myTranslation->removeElement($myTranslation);
    }

    /**
     * Get myTranslation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyTranslation()
    {
        return $this->myTranslation;
    }

    public function __toString()
    {
        return $this->getWord();
    }

    /**
     * Add otherTranslation
     *
     * @param \AppBundle\Entity\Word $otherTranslation
     *
     */
    public function addOtherTranslation(\AppBundle\Entity\Word $otherTranslation)
    {
        $this->otherTranslation[] = $otherTranslation;
    }

    /**
     * Remove otherTranslation
     *
     * @param \AppBundle\Entity\Word $otherTranslation
     */
    public function removeOtherTranslation(\AppBundle\Entity\Word $otherTranslation)
    {
        $this->otherTranslation->removeElement($otherTranslation);
    }

    /**
     * Get otherTranslation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOtherTranslation()
    {
        return $this->otherTranslation;
    }

}

