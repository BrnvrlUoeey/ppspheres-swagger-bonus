<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InputParamController extends AbstractController
{
    /**
     * @Route("/input_param",
     *     name="input_params_get",
     *     methods={"GET"})
     */
    public function index()
    {
        return $this->json([
            'items' => $collections,
        ]);
    }

    /**
     * @Route("/input_param/add",
     *     name="input_param_add",
     *     methods={"POST"}
     *     )
     */
    public function create(string $text, string $format='json')
    {
        $status = [];
        $em = $doctrine->getManager();
        $inputParam = new InputParam($text);
        $em->persist($inputParam);
        $em->flush();
        $lastInsertId = $inputParam->getId();

        if (is_int($lastInsertId) && $lastInsertId > 0) {
            $status = ['code' => 201, 'text' => 'created'];
        } else {
            $status = ['code' => 500, 'text' => 'not created'];
        }

        $return = [
            'created' => $status,
            'id' => $lastInsertId
        ];

        switch ($format) {
            case 'json':
                $return = $this->json($return);
                break;
            case 'php':
                // Keep as it is
                break;
        }
        return $return;
    }

    /**
     * @Route("/input_param/add_many/",
     *     name="input_param_add_many",
     *     methods={"POST"}
     *     )
     */
    public function createMany(array $texts): JsonResponse
    {
        $statuses = [];
        foreach ($texts as $text) {
            $return = $this->create($text, 'php');
            $statuses[] = $return['created'];
            $insertedIds = $return['id' ];
        }

        $response = $this->json([
            'statuses' => $statuses,
            'insertedIds' => $insertedIds
        ]);
        return $response;
    }

    /**
     * @Route("/input_param/delete/{id}",
     *     name="input_param_delete",
     *     methods={"DELETE"},
     *     requirements={"id"="\d+"}
     *     )
     */
    public function delete(int $id)
    {
        $status = [];
        $em = $doctrine->getManager();
        $em->remove($id);
        $em->flush();
        $found = $em->getRepository(InputParam)->findOneById($id);

        if (!empty($found)) {
            $status = ['code' => 204, 'text' => 'no content'];
        } else {
            $status = ['code' => 500, 'text' => 'not deleted'];
        }

        $return = [
            'deleted' => $status,
            'id' => $id
        ];

        switch ($format) {
            case 'json':
                $return = $this->json($return);
                break;
            case 'php':
                // Keep as it is
                break;
        }
        return $return;
    }

    /**
     * @Route("/input_param/delete/{ids}",
     *     name="input_param_delete_many",
     *     methods={"DELETE"},
     *     requirements={"ids"="\d+(,\d)*"}
     *       )
     */
    public function deleteMany(array $ids)
    {
        $statuses = [];
        foreach ($ids as $id) {
            $return = $this->delete($id, 'php');
            $statuses[] = $return['deleted'];
            $deletedIds = $return['id' ];
        }

        $response = $this->json([
                'statuses' => $statuses,
                'deletedIds' => $deletedIds
        ]);
        return $response;
    }
}
