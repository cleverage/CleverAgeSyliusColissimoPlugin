<?php

declare(strict_types=1);

namespace CleverAge\SyliusColissimoPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720154210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cleverage_colissimo_parameter table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cleverage_colissimo_parameter (id INT AUTO_INCREMENT NOT NULL, testModeEnabled TINYINT(1) DEFAULT \'0\' NOT NULL, contractNumber VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, commercialName VARCHAR(255) NOT NULL, companyName VARCHAR(255) NOT NULL, line0 VARCHAR(255) DEFAULT NULL, line1 VARCHAR(255) DEFAULT NULL, line2 VARCHAR(255) NOT NULL, line3 VARCHAR(255) DEFAULT NULL, countryCode VARCHAR(255) NOT NULL, zipCode VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cleverage_colissimo_parameter');
    }
}
