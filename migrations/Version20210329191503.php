<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329191503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $toDo = $schema->createTable('to_do_list');
        $toDo->addColumn('id', Types::BINARY)->setLength(16)->setNotnull(true)->setComment('(DC2Type:ulid)');
        $toDo->addColumn('title', Types::TEXT)->setLength(50)->setNotnull(true);
        $toDo->addColumn('created_at', Types::DATETIME_MUTABLE)->setNotnull(true);
        $toDo->addColumn('updated_at', Types::DATETIME_MUTABLE)->setNotnull(true);
        $toDo->setPrimaryKey(['id']);

        $toDoItem = $schema->createTable('to_do_list_item');
        $toDoItem->addColumn('id', Types::INTEGER)->setAutoincrement(true)->setNotnull(true);
        $toDoItem->addColumn('list_id', Types::BINARY)->setLength(16)->setNotnull(true)->setComment('(DC2Type:ulid)');
        $toDoItem->addColumn('task', Types::TEXT)->setLength(255)->setNotnull(true);
        $toDoItem->addColumn('status', Types::INTEGER)->setNotnull(true);
        $toDoItem->addColumn('created_at', Types::DATETIME_MUTABLE)->setNotnull(true);
        $toDoItem->addColumn('updated_at', Types::DATETIME_MUTABLE)->setNotnull(true);
        $toDoItem->setPrimaryKey(['id']);
        $toDoItem->addIndex(['list_id'], 'IDX_B3FB63A63DAE168B');
        $toDoItem->addForeignKeyConstraint('to_do_list', ['list_id'], ['id'], [], 'FK_B3FB63A63DAE168B');
    }

    public function down(Schema $schema): void
    {
        $schema->getTable('to_do_list_item')->removeForeignKey('FK_B3FB63A63DAE168B');
        $schema->dropTable('to_do_list');
        $schema->dropTable('to_do_list_item');
    }
}
