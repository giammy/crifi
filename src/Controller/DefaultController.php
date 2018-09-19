<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
          $result[$item->getSigla() . " - " . $item->getTarga()] = $item->getId();
          return $result;
        }, array());
        return($assoc_arr);
    }

    function getListaPersoneAsDescId() {
        $l = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->findAll();
        $assoc_arr = array_reduce($l, function ($result, $item) {
          $result[$item->getCognome() . " " . $item->getNome()] = $item->getId();
          return $result;
        }, array());
        return($assoc_arr);
    }

    /**
     * @Route("/", name="homepage"))
     */
    public function index()
    {
        $equi = $this->getUltimoEquipaggio();
//echo("<pre>"); var_dump($equi->getInizio()); exit;
	$repoP = $this->getDoctrine()->getRepository(Persona::class);
        return $this->render('default/index.html.twig', [
            'name' => "HOMEPAGE",
	    'equi' => $equi,
	    'm' => is_null($equi)?null:$this->getDoctrine()->getRepository(Mezzo::class)->find($equi->getIdMezzo()),
	    'listaPersone' => array_map(function ($x) use ($repoP) { 
	           $p = $repoP->find($x[0]);
		   if (is_null($p)) {
		     $cognomeNome = "";
		   } else {
		     $cognomeNome = $p->getCognome() . " " . $p->getNome();
		   }
	    	   return([$cognomeNome, $x[1], $x[2], $x[3], $x[4]]); 
	    }, is_null($equi)?[]:$equi->getIdPersonaABCTLista()),
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
      * @Route("/admin/cancella/equipaggio/{id}", name="admincancellaequipaggio")
      */
    public function cancellaEquipaggio(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella equipaggio");
        $equipaggio = $this->getDoctrine()
                ->getRepository(Equipaggio::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($equipaggio);
        $em->flush();
        return $this->redirectToRoute('mostraequipaggio');
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
      * @Route("/modifica/equipaggio/start", name="modificaequipaggiostart")
      */
    public function modificaEquipaggioStart(Request $request, LoggerInterface $logger)
    {
        $logger->info("modifica equipaggio start");
	$ultimoEquipaggio = $this->getUltimoEquipaggio();
	$equipaggio = new Equipaggio();
	$equipaggio->setInizio(new \DateTime('now'));
	$equipaggio->setFine(null);
	$equipaggio->setNote(null);	 
	$equipaggio->setTipo("S");
	$equipaggio->setQuando("N");
	$equipaggio->setIdPersonaABCTLista([]);
	if (is_null($ultimoEquipaggio)) {
            // nessun equipaggio presente - inizializzane uno di nuovo
	    $equipaggio->setIdMezzo(0);
	    $equipaggio->setNumeroTurno(1);
	} else {
	    $equipaggio->setIdMezzo($ultimoEquipaggio->getIdMezzo());
	    $equipaggio->setNumeroTurno($ultimoEquipaggio->getNumeroTurno() + 1);
 	}
	$em = $this->getDoctrine()->getManager();
	$em->persist($equipaggio);
	$em->flush();
	$id = $equipaggio->getId();
//echo("<pre>"); var_dump($equipaggio); exit;
	return $this->redirectToRoute('modificaequipaggioint', array('id' => $id));
    }

    /**
      * @Route("/modifica/equipaggio/stop/{id}", name="modificaequipaggiostop")
      */
    public function modificaEquipaggioStop(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("modifica equipaggio stop");
        $equipaggio = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->find($id);
	if (is_null($equipaggio)) {
	    return $this->redirectToRoute('homepage');
	} 
	$equipaggio->setFine(new \DateTime('now'));
	$em = $this->getDoctrine()->getManager();
	$em->persist($equipaggio);
	$em->flush();
	return $this->redirectToRoute('homepage');
    }

    /**
      * @Route("/modifica/equipaggio/edit/{id}", name="modificaequipaggioedit")
      */
    public function modificaEquipaggioEdit(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("modifica equipaggio edit");
        $equipaggio = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->find($id);
	if (is_null($equipaggio)) {
	    return $this->redirectToRoute('homepage');
	} 
	return $this->redirectToRoute('modificaequipaggioint', array('id' => $id));
    }

    /**
      * @Route("/modifica/equipaggio/int/{id}", name="modificaequipaggioint")
      */
    public function modificaEquipaggioInt(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("modifica equipaggio");

        $equipaggio = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->find($id);

//echo("<pre>"); var_dump($equipaggio); exit;

	$form = $this->createFormBuilder();
	$form = $form->add('idMezzo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => $this->getListaMezziAsDescId(),
          'data' => $equipaggio->getIdMezzo(),
	));
	$form = $form->add('numeroTurno', TextType::class);
	$form = $form->add('tipo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => array(
	      'SUEM' => 'S',
	      'Altro' => 'x',
	      ),
          'data' => $equipaggio->getTipo(),
          ));
	$form = $form->add('quando', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => array(
	    'Mattina' => 'M',
	    'Pomeriggio' => 'P',
	    'Notte' => 'N',
	  ),
          'data' => $equipaggio->getQuando(),
  	));
	$form = $form->add('note', TextType::class, array(
	       	    'required'    => false,
	));

        // persone 
	$listaPersoneAsDescId = $this->getListaPersoneAsDescId();
	for ($i=0; $i<4; $i++) {
	    $form = $form->add('persona' . $i, ChoiceType::class, array_merge(array(
	      'expanded' => false,
	      'multiple' => false,
	      'choices' => $listaPersoneAsDescId,
              ), empty($equipaggio->getIdPersonaABCTLista())?[]:
                array('data' => $equipaggio->getIdPersonaABCTLista()[$i][0]))
	    );

	    $form = $form->add('autista' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][1],
	       	  'required'    => false));
	    $form = $form->add('blsd' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][2],
	    	  'required'    => false));
	    $form = $form->add('capoequipaggio' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][3],
	    	  'required'    => false));
	    $form = $form->add('tirocinante' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][4],
	    	  'required'    => false));

	}

	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
//echo("<pre>"); var_dump($data); exit;
	    $equipaggio->setIdMezzo($data['idMezzo']);
	    $equipaggio->setNumeroTurno($data['numeroTurno']);
	    $equipaggio->setTipo($data['tipo']);
	    $equipaggio->setQuando($data['quando']);
	    $equipaggio->setNote($data['note']);

	    $equipaggio->setIdPersonaABCTLista([
	      [$data['persona0'], $data['autista0'], $data['blsd0'], $data['capoequipaggio0'], $data['tirocinante0']],
	      [$data['persona1'], $data['autista1'], $data['blsd1'], $data['capoequipaggio1'], $data['tirocinante1']],
	      [$data['persona2'], $data['autista2'], $data['blsd2'], $data['capoequipaggio2'], $data['tirocinante2']],
	      [$data['persona3'], $data['autista3'], $data['blsd3'], $data['capoequipaggio3'], $data['tirocinante3']],
	    ]);

	    $em = $this->getDoctrine()->getManager();
	    $em->persist($equipaggio);
	    $em->flush();

//echo("<pre>"); var_dump($equipaggio); exit;

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
