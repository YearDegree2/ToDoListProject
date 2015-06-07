<?php

namespace ToDoListBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
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
        if ($this->update) {
            $builder->add("Update", "submit", ["attr" => ["class" => "form-control"]]);
        } else {
            $builder->add("Create", "submit", ["attr" => ["class" => "form-control"]]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ToDoListBundle\Entity\Task'
        ));
    }

    public function getName()
    {
        return 'task';
    }
}
