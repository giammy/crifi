<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Validator\Constraints\DateTime;

use App\Entity\Mezzo;
use App\Entity\Persona;
use App\Entity\Equipaggio;
use App\Entity\Intervento;

class DefaultController extends AbstractController
{

    function getUltimoEquipaggio() {
        $last = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->findOneBy(array(), array("id" => "DESC"));
//var_dump($last); exit;
        return $last;
    }

    function getListaMezziAsDescId() {
        $l = $this->getDoctrine()
            ->getRepository(Mezzo::class)
            ->findAll();
        $assoc_arr = array_reduce($l, function ($result, $item) {
          $result[$item->getTarga()] = $item->getId();
          return $result;
        }, array());
        return($assoc_arr);
    }

    /**
     * @Route("/", name="homepage"))
     */
    public function index()
    {
        $e = $this->getUltimoEquipaggio();
        return $this->render('default/index.html.twig', [
            'name' => "HOMEPAGE",
	    'e' => $e,
	    'm' => $this->getDoctrine()
            ->getRepository(Mezzo::class)
            ->find($e->getIdMezzo()),
        ]);
    }


    /**
     * @Route("/nuovo/intervento", name="nuovoIntervento"))
     */
    public function nuovoIntervento()
    {
        return $this->render('default/editIntervento.html.twig', [
            'name' => "HOMEPAGE",
        ]);
    }



    /**
     * @Route("/admin/mostra/mezzo", name="mostramezzo")
     */
    public function showMezzo(LoggerInterface $logger)
    {
        $logger->info("show mezzo");

        $mezzoList = $this->getDoctrine()
            ->getRepository(Mezzo::class)
            ->findAll();

//echo("<pre>"); var_dump($mezzoList); exit;

        return $this->render('default/mostraMezzo.html.twig', [
            'mezzoList' => $mezzoList,
        ]);

    }

    /**
      * @Route("/admin/mostra/persona", name="mostrapersona")
      */
    public function showPersona(LoggerInterface $logger)
    {
        $logger->info("show persona");

        $personaList = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->findAll();

//echo("<pre>"); var_dump($personaList); exit;

        return $this->render('default/mostraPersona.html.twig', [
            'personaList' => $personaList,
        ]);

    }

    /**
     * @Route("/admin/mostra/equipaggio", name="mostraequipaggio")
     */
    public function showEquipaggio(LoggerInterface $logger)
    {
        $logger->info("show equipaggio");

        $equipaggioList = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->findAll();

//echo("<pre>"); var_dump($mezzoList); exit;

        return $this->render('default/mostraEquipaggio.html.twig', [
            'equipaggioList' => $equipaggioList,
        ]);

    }

    /**
      * @Route("/admin/cancella/mezzo/{id}", name="admincancellamezzo")
      */
    public function cancellaMezzo(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella mezzo");
        $mezzo = $this->getDoctrine()
                ->getRepository(Mezzo::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($mezzo);
        $em->flush();
        return $this->redirectToRoute('mostramezzo');
    }

    /**
      * @Route("/modifica/equipaggio/{id}", name="modificaequipaggio")
      */
    public function modificaEquipaggio(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("modifica equipaggio");

	if (is_null($id)) {
            // cerca ultimo equipaggio
	    $equipaggio = $this->getUltimoEquipaggio();
	} else {
            $equipaggio = $this->getDoctrine()
                ->getRepository(Equipaggio::class)
                ->find($id);
	}

	if (is_null($equipaggio)) {
            // nessun equipaggio presente - inizializzane uno di nuovo
	    $equipaggio = new Equipaggio();
	    $equipaggio->setIdMezzo(0);
	    $equipaggio->setNumeroTurno(1);
	    $equipaggio->setTipo("S");
	    $equipaggio->setQuando("N");
	    $equipaggio->setIdPersonaABCTLista([]);
	    $equipaggio->setInizio(new \DateTime('NOW'));
	    $equipaggio->setFine(null);
	    $equipaggio->setNote(null);
	} else {
	    if (!is_null($equipaggio->getFine())) {
	        $oldIdMezzo = $equipaggio->getIdMezzo();
	        $oldNumeroTurno = $equipaggio->getNumeroTurno();
	        $equipaggio = new Equipaggio();
	        $equipaggio->setIdMezzo($oldIdMezzo);
	        $equipaggio->setNumeroTurno($oldNumeroTurno + 1);
	        $equipaggio->setIdPersonaABCTLista([]);
	        $equipaggio->setTipo("S");
	        $equipaggio->setQuando("N");
	        $equipaggio->setInizio(new DateTime('now'));
	        $equipaggio->setFine(null);
		$equipaggio->setNote(null);
	    }
	}

	$form = $this->createFormBuilder();

	$theChoices = $this->getListaMezziAsDescId();
	$form = $form->add('idMezzo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => $theChoices,	
	));
	$form = $form->add('numeroTurno', TextType::class);
	$form = $form->add('tipo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => array(
	      'SUEM' => 'S',
	      'Altro' => 'x',
	      ),
          ));
	$form = $form->add('quando', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => array(
	    'Mattina' => 'M',
	    'Pomeriggio' => 'P',
	    'Notte' => 'N',
	  ),
  	));
	$form = $form->add('note', TextType::class);

//TODO

	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);


	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
	    $equipaggio->setIdMezzo($data['idMezzo']);
	    $equipaggio->setNumeroTurno($data['numeroTurno']);
	    $equipaggio->setTipo($data['tipo']);
	    $equipaggio->setQuando($data['quando']);
	    $equipaggio->setNote($data['note']);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($equipaggio);
	    $em->flush();
	    return $this->redirectToRoute('homepage');
	}
        return $this->render('default/modificaEquipaggio.html.twig', array(
            'form' => $form->createView(),
	    'equipaggio' => $equipaggio,
	    ));
    }

    /**
      * @Route("/admin/modifica/mezzo/{id}", name="adminmodificamezzo")
      */
    public function modificaMezzo(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("modifica mezzo");

	if (is_null($id)) {
	    // crea un nuovo mezzo
	    $mezzo = new Mezzo();
	} else {
            $mezzo = $this->getDoctrine()
                ->getRepository(Mezzo::class)
                ->find($id);
        }
	if (is_null($mezzo)) {
	    // crea un nuovo mezzo
	    $mezzo = new Mezzo();	    
	}

	$form = $this->createFormBuilder();
	$form = $form->add('targa', TextType::class);
	$form = $form->add('codice', TextType::class);
	$form = $form->add('sigla', TextType::class);
	$form = $form->add('altro', TextType::class, array(
    	      'required'   => false,
	      ));
	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
	    $mezzo->setTarga($data['targa']);
	    $mezzo->setCodice($data['codice']);
	    $mezzo->setSigla($data['sigla']);
	    $mezzo->setAltro($data['altro']);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($mezzo);
	    $em->flush();

	    return $this->redirectToRoute('mostramezzo');
	}
        return $this->render('default/adminModificaMezzo.html.twig', array(
            'form' => $form->createView(),
	    'mezzo' => $mezzo,
	    ));
    }

    /**
      * @Route("/admin/cancella/persona/{id}", name="admincancellapersona")
      */
    public function cancellaPersona(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella persona");
        $persona = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($persona);
        $em->flush();
        return $this->redirectToRoute('mostrapersona');
    }

    /**
      * @Route("/admin/modifica/persona/{id}", name="adminmodificapersona")
      */
    public function modificaPersona(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("modifica persona");

	if (is_null($id)) {
	    // crea un nuova persona
	    $persona = new Persona();
	} else {
            $persona = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->find($id);
        }
	if (is_null($persona)) {
	    // crea un nuova persona
	    $persona = new Persona();	    
	}

	$form = $this->createFormBuilder();
	$form = $form->add('nome', TextType::class);
	$form = $form->add('cognome', TextType::class);
	$form = $form->add('codiceFiscale', TextType::class);
	$form = $form->add('codiceCRI', TextType::class);
	$form = $form->add('altro', TextType::class, array(
    	      'required'   => false,
	      ));
	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
	    $persona->setNome($data['nome']);
	    $persona->setCognome($data['cognome']);
	    $persona->setCodiceFiscale($data['codiceFiscale']);
	    $persona->setCodiceCRI($data['codiceCRI']);
	    $persona->setAltro($data['altro']);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($persona);
	    $em->flush();

	    return $this->redirectToRoute('mostrapersona');
	}
        return $this->render('default/adminModificaPersona.html.twig', array(
            'form' => $form->createView(),
	    'persona' => $persona,
	    ));
    }

    /**
      * @Route("/crea")
      */
    public function crea(LoggerInterface $logger)
    {
        $logger->info("Crea db entries");
	$entityManager = $this->getDoctrine()->getManager();

	$mezzo = new Mezzo();
	$mezzo->setTarga("CRI12345");
	$mezzo->setCodice("PD351234");
	$mezzo->setSigla("R12");
	$mezzo->setAltro("");
        $entityManager->persist($mezzo);
	$entityManager->flush();

	$mezzo = new Mezzo();
	$mezzo->setTarga("CRI67890");
	$mezzo->setCodice("PD351567");
	$mezzo->setSigla("R18");
	$mezzo->setAltro("");
        $entityManager->persist($mezzo);
	$entityManager->flush();

	$persona = new Persona();
	$mezzo = new Mezzo();
	$persona->setNome("Giorgio");
	$persona->setCognome("Gini");
	$persona->setCodiceFiscale("GNIGRG");
	$persona->setCodiceCRI("TACRI1");
	$persona->setAltro("");
        $entityManager->persist($persona);
	$entityManager->flush();

	$persona = new Persona();
	$mezzo = new Mezzo();
	$persona->setNome("Pino");
	$persona->setCognome("Paoli");
	$persona->setCodiceFiscale("PNIPLI");
	$persona->setCodiceCRI("TACRI2");
	$persona->setAltro("");
        $entityManager->persist($persona);
	$entityManager->flush();


        return $this->render('default/index.html.twig', [ 'name' => "Creati!" ]);
    }


    /**
      * @Route("/hello/{name}")
      */
    public function hello($name, LoggerInterface $logger)
    {
        $logger->info("Saying hello to $name!");
        return $this->render('default/index.html.twig', [
            'name' => $name,
        ]);
    }


//
// API
//
    /**
     * @Route("/api/hello/{name}")
     */
    public function apiExample($name)
    {
        return $this->json([
            'name' => $name,
            'symfony' => 'rocks',
        ]);
    }

}
