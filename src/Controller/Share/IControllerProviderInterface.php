<?php


namespace App\Controller\Share;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IControllerProviderInterface
{
    public function create(Request $request): JsonResponse;
    public function delete(string $value): JsonResponse;
    public function getAll(): JsonResponse;
    public function filterOneBy(string $value): JsonResponse;
}