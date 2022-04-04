<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Frame;
use App\Exception\NotExistsException;
use App\Parameters\CreateFrameParameters;

class FrameService extends AbstractEntityService
{
    /**
     * Creates new Frame from parameters or updates an existing by passing its entity
     *
     * @throws NotExistsException
     */
    public function create(CreateFrameParameters $params, Frame $frame = new Frame()): Frame
    {
        if ($image = $params->getImage()) {
            $frame->setImage($image);
        }
        if ($movieId = $params->getMovieId()) {
            if (!$movieEntity = $this->getEntityRepository(\App\Entity\Movie::class)->find($movieId)) {
                throw new NotExistsException("Selected category does not exist.");
            }
            $frame->setMovie($movieEntity);
        }

        return $frame;
    }
}
