<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertChallenges extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $builder = $this->getQueryBuilder();
        $builder
            ->insert(['id','name', 'description','explanation','thophy_video'])
            ->into('challenges')
            ->values([
                'id' => 1, 
                'name' => 'Memoria', 
                'description' => 'description memoria', 
                'explanation' => 'explanation memoria',
                'thophy_video' => 'v1.mp4'
            ])
            ->values([
                'id' => 2, 
                'name' => 'Quiz', 
                'description' => 'description quiz', 
                'explanation' => 'explanation quiz',
                'thophy_video' => 'v2.mp4'
            ])
            ->execute();
    }

    public function down(): void
    {
        $builder = $this->getQueryBuilder();
        $builder
            ->delete('challenges')
            ->execute();
    }
}
