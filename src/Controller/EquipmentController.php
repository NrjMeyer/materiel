<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipment;

class EquipmentController extends AbstractController
{
    //Ajouter un equipement
    /**
     * @Route("/equipment", name="add_equipment", methods={"POST"})
     */
    public function addEquipment(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $equipment = new Equipment();
        $parameters = json_decode($request->getContent(), true);
        $equipment->setName($parameters['name']);
        $equipment->setCategory($parameters['category']);
        $equipment->setNumber($parameters['number']);
        $equipment->setDescription($parameters['description']);
        $equipment->setCreatedAt(new \DateTime());

        $entityManager->persist($equipment);
        $entityManager->flush();

        return $this->json(['id' => $equipment->getId()]);
    }

    /// Modifier un équipement
    /**
     * @Route("/equipment/{id}", name="update_equipment", methods={"PUT"})
     */
    public function updateEquipment($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $equipment = $entityManager->getRepository(Equipment::class)->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException(
                'No equipment found for id '.$id
            );
        }

        $parameters = json_decode($request->getContent(), true);
        if(isset($parameters['name'])) $equipment->setName($parameters['name']);
        if(isset($parameters['category'])) $equipment->setCategory($parameters['category']);
        if(isset($parameters['number'])) $equipment->setNumber($parameters['number']);
        if(isset($parameters['description'])) $equipment->setDescription($parameters['description']);
        $equipment->setUpdatedAt(new \DateTime());

        $entityManager->flush();

        return $this->json(['status' => 'Equipment updated successfully']);
    }

    // Supprimer un équipement
    /**
     * @Route("/equipment/{id}", name="delete_equipment", methods={"DELETE"})
     */
    public function deleteEquipment($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $equipment = $entityManager->getRepository(Equipment::class)->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException(
                'No equipment found for id '.$id
            );
        }

        $entityManager->remove($equipment);
        $entityManager->flush();

        return $this->json(['status' => 'Equipment deleted successfully']);
    }

    // Afficher tous les équipements avec un filtre par catégorie
    /**
     * @Route("/equipments", name="get_all_equipment", methods={"GET"})
     */
    public function getAllEquipment(Request $request)
    {
        $category = $request->query->get('category');

        if ($category) {
            $equipments = $this->getDoctrine()->getRepository(Equipment::class)->findBy(['category' => $category]);
        } else {
            $equipments = $this->getDoctrine()->getRepository(Equipment::class)->findAll();
        }

        return $this->json(['equipments' => array_map(function ($equipment) {
            return [
                'id' => $equipment->getId(),
                'name' => $equipment->getName(),
                'category' => $equipment->getCategory(),
                'number' => $equipment->getNumber(),
                'description' => $equipment->getDescription(),
                'createdAt' => $equipment->getCreatedAt(),
                'updatedAt' => $equipment->getUpdatedAt(),
            ];
        }, $equipments)]);
    }
}
