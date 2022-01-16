<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ViewFilmCategories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $sql = <<<EOT
CREATE VIEW view_film_categories AS
	SELECT
	    categories.id,
	    categories.name,
	    count(film_categories.uuid) as total
	FROM
	    categories
	LEFT JOIN
	    film_categories on film_categories.category_id = categories.id
	GROUP BY
		categories.name;
EOT;

        $this->query($sql);
    }
}
