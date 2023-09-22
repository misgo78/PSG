<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906141058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5CECC7BEA76ED395 ON adress (user_id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BEA76ED395');
        $this->addSql('DROP INDEX IDX_5CECC7BEA76ED395 ON adress');
        $this->addSql('ALTER TABLE adress DROP user_id');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15BCF5E72D');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA152BCFB58A');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F61190A32');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF6D861B89');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFA0905086');
        $this->addSql('ALTER TABLE rencontre DROP FOREIGN KEY FK_460C35ED7B39D312');
    }
}
