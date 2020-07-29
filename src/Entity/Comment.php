<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get",
 *          "post"={"security"="is_granted('ROLE_USER')"}
 *      },
 *      itemOperations={
 *          "get",
 *          "put"={"security"="is_granted('ROLE_ADMIN') or object.getAuthor() == user"},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object.getAuthor() == user"}
 *      },
 *      normalizationContext={"groups"={"comment:read"}},
 *      denormalizationContext={"groups"={"comment:write"}}
 * )
 * 
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"comment:read", "comment:write"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("comment:read")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     * @Groups({"comment:read", "comment:write"})
     */
    private $article;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

}
