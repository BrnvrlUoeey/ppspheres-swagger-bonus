<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExpressionController extends AbstractController
{
    /**
     * @Route("/expression", name="expressions_get", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'items' => $collections,
        ]);
    }

    /**
     * @Route("/api/expression/add/",
     *     name="expression_add",
     *     methods={"POST"}
     *     )
     */
    public function create(string $text, $format='json')
    {
        $status = [];
        $em = $doctrine->getManager();
        $expression = new Expression($text);
        $em->persist($expression);
        $em->flush();
        $lastInsertId = $expression->getId();

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
     * @Route("/expression/add_many/",
     *     name="expression_add_many",
     *     methods={"POST"}
     *     )
     */
    public function createMany($texts): JsonResponse
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
     * @Route("/expression/delete/{id}",
     *     name="expression_delete",
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
        $found = $em->getRepository(Expression)->findOneById($id);

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
     * @Route("/expression/delete/{ids}",
     *     name="expression_delete_many",
     *     methods={"DELETE"},
     *     requirements={"ids"="\d+(,\d)*"}
     *       )
     */
    public function deleteMany($ids)
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
