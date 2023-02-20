<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20230220165038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE attributes (id BLOB NOT NULL --(DC2Type:id)
        , creator_id BLOB DEFAULT NULL --(DC2Type:id)
        , code VARCHAR(255) NOT NULL COLLATE "BINARY" --(DC2Type:code)
        , type VARCHAR(255) NOT NULL COLLATE "BINARY" --(DC2Type:type)
        , created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetimetz_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_319B9E7061220EA6 FOREIGN KEY (creator_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_319B9E7077153098 ON attributes (code)');
        $this->addSql('CREATE INDEX IDX_319B9E7061220EA6 ON attributes (creator_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_319B9E7077153098 ON attributes (code)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE attributes_values (id BLOB NOT NULL --(DC2Type:id)
        , creator_id BLOB DEFAULT NULL --(DC2Type:id)
        , attribute_id BLOB DEFAULT NULL --(DC2Type:id)
        , product_id BLOB DEFAULT NULL --(DC2Type:id)
        , value VARCHAR(255) DEFAULT NULL COLLATE "BINARY" --(DC2Type:value)
        , parent BLOB DEFAULT NULL --(DC2Type:id)
        , created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetimetz_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_E6D185B861220EA6 FOREIGN KEY (creator_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E6D185B8B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E6D185B84584665A FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6D185B8B6E62EFA4584665A3D8E604F ON attributes_values (attribute_id, product_id, parent)');
        $this->addSql('CREATE INDEX IDX_E6D185B83D8E604F ON attributes_values (parent)');
        $this->addSql('CREATE INDEX IDX_E6D185B84584665A ON attributes_values (product_id)');
        $this->addSql('CREATE INDEX IDX_E6D185B8B6E62EFA ON attributes_values (attribute_id)');
        $this->addSql('CREATE INDEX IDX_E6D185B861220EA6 ON attributes_values (creator_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE categories (id BLOB NOT NULL --(DC2Type:id)
        , creator_id BLOB DEFAULT NULL --(DC2Type:id)
        , created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetimetz_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_3AF3466861220EA6 FOREIGN KEY (creator_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3AF3466861220EA6 ON categories (creator_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE glossary (id BLOB NOT NULL --(DC2Type:id)
        , parent_id BLOB NOT NULL --(DC2Type:id)
        , locale VARCHAR(255) NOT NULL COLLATE "BINARY" --(DC2Type:locale)
        , field VARCHAR(255) NOT NULL COLLATE "BINARY", value VARCHAR(255) DEFAULT NULL COLLATE "BINARY", PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0850B43727ACA704180C6985BF54558 ON glossary (parent_id, locale, field)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE products (id BLOB NOT NULL --(DC2Type:id)
        , creator_id BLOB DEFAULT NULL --(DC2Type:id)
        , category_id BLOB DEFAULT NULL --(DC2Type:id)
        , created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetimetz_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_B3BA5A5A61220EA6 FOREIGN KEY (creator_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A61220EA6 ON products (creator_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE products_to_units (product_id BLOB NOT NULL --(DC2Type:id)
        , unit_id BLOB NOT NULL --(DC2Type:id)
        , PRIMARY KEY(product_id, unit_id), CONSTRAINT FK_F78D55CA4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F78D55CAF8BD700D FOREIGN KEY (unit_id) REFERENCES units (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F78D55CAF8BD700D ON products_to_units (unit_id)');
        $this->addSql('CREATE INDEX IDX_F78D55CA4584665A ON products_to_units (product_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE units (id BLOB NOT NULL --(DC2Type:id)
        , creator_id BLOB DEFAULT NULL --(DC2Type:id)
        , created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetimetz_immutable)
        , suggestions CLOB NOT NULL COLLATE "BINARY" --(DC2Type:suggestions)
        , PRIMARY KEY(id), CONSTRAINT FK_E9B0744961220EA6 FOREIGN KEY (creator_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E9B0744961220EA6 ON units (creator_id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('CREATE TABLE users (id BLOB NOT NULL --(DC2Type:id)
        , sso_id VARCHAR(255) NOT NULL COLLATE "BINARY", created_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetimetz_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E97843BFA4 ON users (sso_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE attributes');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE attributes_values');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE categories');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE glossary');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE products');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE products_to_units');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE units');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\SqlitePlatform'."
        );

        $this->addSql('DROP TABLE users');
    }
}
