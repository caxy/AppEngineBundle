<?php

namespace Caxy\Bundle\AppEngineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class CommandController.
 *
 * @Sensio\Route("/_console")
 */
class ConsoleController extends Controller
{
    /**
     * @Sensio\Route("/")
     * @Sensio\Template()
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function indexAction(Request $request)
    {
        $data = array(
            'command' => 'list',
        );

        $form = $this->createFormBuilder($data)
            ->add('command', 'text', array(
                'label' => false,
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array('pattern' => '/^[^\:]++(\:[^\:]++)*$/')),
                ),
            ))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
        }

        $input = new StringInput($data['command']);
        $input->setInteractive(false);

        $output = new BufferedOutput();

        $application = $this->get('console.application');
        $application->setAutoExit(false);

        $errorCode = $application->run($input, $output);

        $response = new Response();
        $response->setStatusCode($errorCode === 0 ? 200 : 500);

        return $this->render('CaxyAppEngineBundle:Console:index.html.twig', array(
            'form' => $form->createView(),
            'output' => $output->fetch(),
        ), $response);
    }
}
