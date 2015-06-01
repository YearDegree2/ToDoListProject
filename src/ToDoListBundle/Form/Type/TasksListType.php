<?php

namespace ToDoListBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('deadline', 'date');
        $builder->add('Créer', 'submit');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
            $resolver->setDefaults(array(
                    'data_class' => 'ToDoListBundle\Entity\TasksList'
                    ));
        }

    public function getName()
    {
            return 'taskLists';
    }
}
