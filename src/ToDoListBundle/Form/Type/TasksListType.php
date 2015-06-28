<?php

namespace ToDoListBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksListType extends AbstractType
{
    private $update;
    private $dataClass;
    private $google;

    public function __construct($update = false, $dataClass = 'ToDoListBundle\Entity\Taskslist', $google = false)
    {
        $this->update = $update;
        $this->dataClass = $dataClass;
        $this->google = $google;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->google) {
            $builder->add("name", "text", [
                "label" => "Name",
                "attr" => ["placeholder" => "Name",
                "class" => "form-control"]]);
            $builder->add("deadline", "date", [
                "label" => "Deadline"]);
        } else {
            $builder->add("title", "text", [
                "label" => "Name",
                "attr" => ["placeholder" => "Name",
                    "class" => "form-control"]]);
        }
        if ($this->update) {
            $builder->add("Update", "submit", ["attr" => ["class" => "form-control"]]);
        } else {
            $builder->add("Create", "submit", ["attr" => ["class" => "form-control"]]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => $this->dataClass
        ));
    }

    public function getName()
    {
        return 'tasksList';
    }
}
