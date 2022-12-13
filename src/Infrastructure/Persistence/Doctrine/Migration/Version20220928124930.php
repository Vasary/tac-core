<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928124930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, creator_id UUID DEFAULT NULL, category_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_b3ba5a5a12469de2 ON products (category_id)');
        $this->addSql('CREATE INDEX idx_b3ba5a5a61220ea6 ON products (creator_id)');
        $this->addSql('COMMENT ON COLUMN products.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN products.creator_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN products.category_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN products.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN products.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN products.deleted_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE glossary (id UUID NOT NULL, parent_id UUID NOT NULL, locale VARCHAR(255) NOT NULL, field VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_b0850b43727aca704180c6985bf54558 ON glossary (parent_id, locale, field)');
        $this->addSql('COMMENT ON COLUMN glossary.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN glossary.parent_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN glossary.locale IS \'(DC2Type:locale)\'');
        $this->addSql('CREATE TABLE products_to_units (product_id UUID NOT NULL, unit_id UUID NOT NULL, PRIMARY KEY(product_id, unit_id))');
        $this->addSql('CREATE INDEX idx_f78d55caf8bd700d ON products_to_units (unit_id)');
        $this->addSql('CREATE INDEX idx_f78d55ca4584665a ON products_to_units (product_id)');
        $this->addSql('COMMENT ON COLUMN products_to_units.product_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN products_to_units.unit_id IS \'(DC2Type:id)\'');
        $this->addSql('CREATE TABLE attributes_values (id UUID NOT NULL, creator_id UUID DEFAULT NULL, attribute_id UUID DEFAULT NULL, product_id UUID DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, parent UUID DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_e6d185b83d8e604f ON attributes_values (parent)');
        $this->addSql('CREATE INDEX idx_e6d185b84584665a ON attributes_values (product_id)');
        $this->addSql('CREATE INDEX idx_e6d185b8b6e62efa ON attributes_values (attribute_id)');
        $this->addSql('CREATE INDEX idx_e6d185b861220ea6 ON attributes_values (creator_id)');
        $this->addSql('COMMENT ON COLUMN attributes_values.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.creator_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.attribute_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.product_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.value IS \'(DC2Type:value)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.parent IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN attributes_values.deleted_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE attributes (id UUID NOT NULL, creator_id UUID DEFAULT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_319b9e7077153098 ON attributes (code)');
        $this->addSql('CREATE INDEX idx_319b9e7061220ea6 ON attributes (creator_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_319b9e7077153098 ON attributes (code)');
        $this->addSql('COMMENT ON COLUMN attributes.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes.creator_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN attributes.code IS \'(DC2Type:code)\'');
        $this->addSql('COMMENT ON COLUMN attributes.type IS \'(DC2Type:type)\'');
        $this->addSql('COMMENT ON COLUMN attributes.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN attributes.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN attributes.deleted_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE categories (id UUID NOT NULL, creator_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_3af3466861220ea6 ON categories (creator_id)');
        $this->addSql('COMMENT ON COLUMN categories.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN categories.creator_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN categories.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN categories.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN categories.deleted_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE units (id UUID NOT NULL, creator_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, suggestions JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_e9b0744961220ea6 ON units (creator_id)');
        $this->addSql('COMMENT ON COLUMN units.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN units.creator_id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN units.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN units.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN units.deleted_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN units.suggestions IS \'(DC2Type:suggestions)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, email VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON users (email)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.deleted_at IS \'(DC2Type:datetimetz_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE glossary');
        $this->addSql('DROP TABLE products_to_units');
        $this->addSql('DROP TABLE attributes_values');
        $this->addSql('DROP TABLE attributes');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE units');
        $this->addSql('DROP TABLE users');
    }
}
