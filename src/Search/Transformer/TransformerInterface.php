<?php

namespace App\Search\Transformer;

interface TransformerInterface
{
    public function transformCollection(array $data): array;

    public function transformOne(mixed $data): mixed;
}
