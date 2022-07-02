<?php
declare(strict_types=1);

namespace App\Test\Factory;

use Cake\Utility\Text;
use CakephpFixtureFactories\Factory\BaseFactory;
use Faker\Generator;

class UserFactory extends BaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return "Users"; // PascalCase of the factory's table.
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
                'id' => Text::uuid(),
                'created' => $faker->dateTime(),
                'modified'  => $faker->dateTime(),
            ];
        });
    }
}
