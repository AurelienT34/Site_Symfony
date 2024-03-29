<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table(name="article", indexes={@ORM\Index(columns={"title", "content"}, flags={"fulltext"})})
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="Votre tritre est trop court", maxMessage="Votre titre est trop long")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=250,minMessage="Contenu trop court [250 caractères minimun]")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(message = "The url '{{ value }}' is not a valid url")
     */
    private $image;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Gedmo\Slug(fields={"title","id"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    { // Pour fixtures
        $this->createAt = $createAt;

        return $this;
    }

    public function setCreateAtFromString(string $dateString)
    {
        //2020-11-18 00:00:00.000000
        $dateStringStepOne = explode(" ",$dateString);
        $dateStringFinal = explode("-",$dateStringStepOne[0]);
        $date = new \DateTime();

        $date->setDate(intval($dateStringFinal[0]),intval($dateStringFinal[1]),intval($dateStringFinal[2]));
        $this->createAt = $date;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }
}
