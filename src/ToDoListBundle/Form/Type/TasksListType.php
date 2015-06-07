<?php

namespace ToDoListBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksListType extends AbstractType
{
    private $update;

    public function __construct($update = false)
    {
        $this->update = $update;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", "text", [
            "label" => "Name",
            "attr" => ["placeholder" => "Name",
            "class" => "form-control"]]);
        $builder->add("deadline", "date", [
            "label" => "Deadline"]);
        if ($this->update) {
            $builder->add("Update", "submit", ["attr" => ["class" => "form-control"]]);
        } else {
            $builder->add("Create", "submit", ["attr" => ["class" => "form-control"]]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ToDoListBundle\Entity\TasksList'
        ));
    }

    public function getName()
    {
        return 'tasksList';
    }
}
