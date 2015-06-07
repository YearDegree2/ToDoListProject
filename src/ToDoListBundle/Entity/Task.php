<?php

namespace ToDoListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="Task", indexes={@ORM\Index(name="taskslist_id", columns={"taskslist_id"})})
 * @ORM\Entity
 */
class Task
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ToDoListBundle\Entity\Taskslist
     *
     * @ORM\ManyToOne(targetEntity="ToDoListBundle\Entity\Taskslist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="taskslist_id", referencedColumnName="id")
     * })
     */
    private $taskslist;

    /**
     * Set name
     *
     * @param  string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param  integer $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set taskslist
     *
     * @param  \ToDoListBundle\Entity\Taskslist $taskslist
     * @return Task
     */
    public function setTaskslist(\ToDoListBundle\Entity\Taskslist $taskslist = null)
    {
        $this->taskslist = $taskslist;

        return $this;
    }

    /**
     * Get taskslist
     *
     * @return \ToDoListBundle\Entity\Taskslist
     */
    public function getTaskslist()
    {
        return $this->taskslist;
    }
}
