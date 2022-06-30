<?php
declare(strict_types=1);

namespace AuthenticationApi\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use Faker\Generator;

class ActorFactory extends BaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return "Actors"; // PascalCase of the factory's table.
    }

    /**
     * Defines the default values of you factory. Useful for
     * not nullable fields.
     * Use the patchData method to set the field values.
     * You may use methods of the factory here
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function(Generator $faker) {
            return [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'modified'  => $faker->dateTime(),
            ];
        });
    }
}
