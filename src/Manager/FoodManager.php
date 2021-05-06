<?php

declare(strict_types=1);

namespace App\Manager;


use App\Entity\Food;
use App\Repository\FoodRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class FoodManager
{
    /**
     * @var FoodRepository $foodRepository
     */
    protected $foodRepository;

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * FoodManager constructor.
     * @param FoodRepository $foodRepository
     * @param EntityManager $entityManager
     */
    public function __construct(FoodRepository $foodRepository, EntityManager $entityManager)
    {
        $this->foodRepository = $foodRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @param int $id
     * @return Food|null
     */
    public function getFoodById(int $id): ?Food
    {
        return $this->foodRepository->findOneBy(["id" => $id]);
    }

    /**
     * @param string $name
     * @return Food|null
     */
    public function getFoodByName(string $name): ?Food
    {
        return $this->foodRepository->findOneBy(["name" => $name]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createFood(Food $food)
    {
        $this->entityManager->persist($food);
        $this->entityManager->flush();
    }


}