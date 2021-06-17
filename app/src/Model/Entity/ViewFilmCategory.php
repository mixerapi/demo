<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use SwaggerBake\Lib\Annotation\SwagEntity;
use SwaggerBake\Lib\Annotation\SwagEntityAttribute;

/**
 * ViewFilmCategory Entity
 * @SwagEntity(isPublic=false)
 * @SwagEntityAttribute(name="id", type="integer", format="int32", example="1")
 * @SwagEntityAttribute(name="name", type="string", example="Action")
 * @SwagEntityAttribute(name="total", type="integer", format="int64", example="100")
 */
class ViewFilmCategory extends Entity
{

}
