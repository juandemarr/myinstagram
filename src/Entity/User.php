<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"nombreUsuario"}, message="There is already an account with this nombreUsuario")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $nombreUsuario;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreCompleto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fechaNac;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="autor", orphanRemoval=true)
     */
    private $totalPosts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fotoPerfil;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="likes")
     */
    private $likesPost;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="followers")
     */
    private $followed;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="followed")
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity=Report::class, mappedBy="idUser", orphanRemoval=true)
     */
    private $reports;

    public function __construct()
    {
        $this->totalPosts = new ArrayCollection();
        $this->likesPost = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->followed = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreUsuario(): ?string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(string $nombreUsuario): self
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->nombreUsuario;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->nombreUsuario;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombreCompleto(): ?string
    {
        return $this->nombreCompleto;
    }

    public function setNombreCompleto(string $nombreCompleto): self
    {
        $this->nombreCompleto = $nombreCompleto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaNac(): ?string
    {
        return $this->fechaNac;
    }

    public function setFechaNac(string $fechaNac): self
    {
        $this->fechaNac = $fechaNac;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function __toString()
    {
        return $this->nombreUsuario;
    }
    /**
     * @return Collection|Post[]
     */
    public function getTotalPosts(): Collection
    {
        return $this->totalPosts;
    }

    public function addTotalPosts(Post $totalPosts): self
    {
        if (!$this->totalPosts->contains($totalPosts)) {
            $this->totalPosts[] = $totalPosts;
            $totalPosts->setAutor($this);
        }

        return $this;
    }

    public function removeTotalPosts(Post $totalPosts): self
    {
        if ($this->totalPosts->removeElement($totalPosts)) {
            // set the owning side to null (unless already changed)
            if ($totalPosts->getAutor() === $this) {
                $totalPosts->setAutor(null);
            }
        }

        return $this;
    }

    public function getFotoPerfil(): ?string
    {
        return $this->fotoPerfil;
    }

    public function setFotoPerfil(?string $fotoPerfil): self
    {
        $this->fotoPerfil = $fotoPerfil;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getLikesPost(): Collection
    {
        return $this->likesPost;
    }

    public function addLikesPost(Post $likesPost): self
    {
        if (!$this->likesPost->contains($likesPost)) {
            $this->likesPost[] = $likesPost;
            $likesPost->addLike($this);
        }

        return $this;
    }

    public function removeLikesPost(Post $likesPost): self
    {
        if ($this->likesPost->removeElement($likesPost)) {
            $likesPost->removeLike($this);
        }

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFollowed(): Collection
    {
        return $this->followed;
    }

    public function addFollowed(self $followed): self
    {
        if (!$this->followed->contains($followed)) {
            $this->followed[] = $followed;
        }

        return $this;
    }

    public function removeFollowed(self $followed): self
    {
        $this->followed->removeElement($followed);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(self $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->addFollowed($this);
        }

        return $this;
    }

    public function removeFollower(self $follower): self
    {
        if ($this->followers->removeElement($follower)) {
            $follower->removeFollowed($this);
        }

        return $this;
    }

    /**
     * @return Collection|Report[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setIdUser($this);
        }

        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getIdUser() === $this) {
                $report->setIdUser(null);
            }
        }

        return $this;
    }

}
