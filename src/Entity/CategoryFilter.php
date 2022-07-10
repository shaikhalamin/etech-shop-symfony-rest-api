<?php

namespace App\Entity;

use App\Repository\CategoryFilterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryFilterRepository::class)]
class CategoryFilter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryFilters')]
    private $category;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\OneToMany(mappedBy: 'categoryFilter', targetEntity: CategoryFilterItem::class)]
    private $categoryFilterItems;

    public function __construct()
    {
        $this->categoryFilterItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, CategoryFilterItem>
     */
    public function getCategoryFilterItems(): Collection
    {
        return $this->categoryFilterItems;
    }

    public function addCategoryFilterItem(CategoryFilterItem $categoryFilterItem): self
    {
        if (!$this->categoryFilterItems->contains($categoryFilterItem)) {
            $this->categoryFilterItems[] = $categoryFilterItem;
            $categoryFilterItem->setCategoryFilter($this);
        }

        return $this;
    }

    public function removeCategoryFilterItem(CategoryFilterItem $categoryFilterItem): self
    {
        if ($this->categoryFilterItems->removeElement($categoryFilterItem)) {
            // set the owning side to null (unless already changed)
            if ($categoryFilterItem->getCategoryFilter() === $this) {
                $categoryFilterItem->setCategoryFilter(null);
            }
        }

        return $this;
    }
}
