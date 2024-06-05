<?php
namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'articles')]
class Article
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;

#[ORM\Column(length: 255)]
private ?string $title = null;

#[ORM\Column(length: 255)]
private ?string $content = null;

#[ORM\Column(type: 'datetime_immutable')]
#[Assert\Type(DateTimeImmutable::class)]
#[Gedmo\Timestampable(on: 'create')]
private ?\DateTimeImmutable $createdAt;

#[ORM\Column(type: 'datetime_immutable')]
#[Assert\Type(DateTimeImmutable::class)]
#[Gedmo\Timestampable(on: 'update')]
private ?\DateTimeImmutable $updatedAt;

#[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
#[ORM\JoinColumn(nullable: false)]
private ?Category $category = null;

#[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'articles', fetch: 'EXTRA_LAZY')]
#[ORM\JoinTable(name: 'articles_tags')]
private Collection $tags;

public function __construct()
{
$this->tags = new ArrayCollection();
}

public function getId(): ?int
{
return $this->id;
}

public function getTitle(): ?string
{
return $this->title;
}

public function setTitle(string $title): static
{
$this->title = $title;
return $this;
}

public function getContent(): ?string
{
return $this->content;
}

public function setContent(string $content): static
{
$this->content = $content;
return $this;
}

public function getCreatedAt(): ?\DateTimeInterface
{
return $this->createdAt;
}

public function setCreatedAt(\DateTimeInterface $createdAt): static
{
$this->createdAt = $createdAt;
return $this;
}

public function getUpdatedAt(): ?\DateTimeInterface
{
return $this->updatedAt;
}

public function setUpdatedAt(\DateTimeInterface $updatedAt): static
{
$this->updatedAt = $updatedAt;
return $this;
}

public function getCategory(): ?Category
{
return $this->category;
}

public function setCategory(?Category $category): static
{
$this->category = $category;
return $this;
}

public function getTags(): Collection
{
return $this->tags;
}

public function addTag(Tag $tag): static
{
if (!$this->tags->contains($tag)) {
$this->tags->add($tag);
$tag->addArticle($this);
}
return $this;
}

public function removeTag(Tag $tag): static
{
if ($this->tags->removeElement($tag)) {
$tag->removeArticle($this);
}
return $this;
}




}
