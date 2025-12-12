<?php

namespace App\Search\Transformer;

use App\Search\Transformer\TransformerInterface;

abstract class AbstractDataTransformer implements TransformerInterface
{

    public function transformCollection(array $data): array
    {
        $conferences = [];

        foreach ($data as $datum) {
            $conferences[] = $this->transformOne($datum);
        }

        return $conferences;
    }
}
