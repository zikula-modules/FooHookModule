<?php

namespace Zikula\FooHookModule\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\NotBlank;
use Zikula\Bundle\HookBundle\Hook\Hook;
use Zikula\Bundle\HookBundle\Hook\ProcessHook;
use Zikula\Bundle\HookBundle\Hook\ValidationHook;
use Zikula\Bundle\HookBundle\Hook\ValidationResponse;
use Zikula\Core\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction(Request $request, $name = 'no name')
    {
        return ['name' => $name];
    }

    /**
     * @Route("/foo")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function fooAction(Request $request)
    {
        $name = 'unsubmitted';
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['constraints' => [new NotBlank()]])
            ->add('save', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($this->hookValidates($form, 'validate_edit')) {
                $data = $form->getData();
                $name = 'submitted: ' . $data['name'];
                $this->notifyHooks(new ProcessHook(1),'foo.ui_hooks.process_edit');
            }
        }

        return [
            'form' => $form->createView(),
            'name' => $name
        ];
    }

    /**
     * Checks whether or not the hook validates.
     *
     * @param Form $form
     * @param string $event
     *
     * @return bool
     */
    private function hookValidates(Form $form, $event)
    {
        $validationHook = new ValidationHook();
        /** @var ValidationHook $validationHook */
        $validationHook = $this->notifyHooks($validationHook, "foo.ui_hooks.$event");
        $hookvalidators = $validationHook->getValidators();

        if (!$hookvalidators->hasErrors()) {
            return true;
        }

        /** @var ValidationResponse $validationResponse */
        foreach ($hookvalidators as $validationResponse) {
            foreach ($validationResponse->getErrors() as $error) {
                $form->addError(new FormError($error));
            }
        }

        return false;
    }

    /**
     * Notifies subscribers of the given hook.
     *
     * @param Hook $hook
     * @param $name
     *
     * @return Hook
     */
    private function notifyHooks(Hook $hook, $name)
    {
        return $this->get('hook_dispatcher')->dispatch($name, $hook);
    }
}

