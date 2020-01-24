<?php


namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Component\DTO\FragmentDTO;

/**
 * Class FragmentDataPersister
 * @package App\Component\DataPersister
 */
final class FragmentDataPersister implements ContextAwareDataPersisterInterface
{
    public function persist($data, array $context = [])
    {
        // call your persistence layer to save $data
        // persist $fragment

        //send back data

        return $data;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof FragmentDTO;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}