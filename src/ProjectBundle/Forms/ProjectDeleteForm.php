<?php
/**
 * Created by PhpStorm.
 * User: Одмен
 * Date: 21.09.18
 * Time: 20:34
 */

namespace ProjectBundle\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectDeleteForm extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', new HiddenType(), [ 'data' => $options['delete_id']] )
            ->add('submit', new SubmitType(), ['label' => 'Delete']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['delete_id' => null]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['delete_id'] = $options['delete_id'];
    }


} 