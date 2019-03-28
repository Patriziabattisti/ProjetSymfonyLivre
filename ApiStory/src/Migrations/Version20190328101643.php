<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190328101643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, origine_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, description_physique LONGTEXT DEFAULT NULL, description_psychologique LONGTEXT DEFAULT NULL, INDEX IDX_6AEA486D87998E (origine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage_personnage (personnage_source INT NOT NULL, personnage_target INT NOT NULL, INDEX IDX_F1BF9378992CF5CD (personnage_source), INDEX IDX_F1BF937880C9A542 (personnage_target), PRIMARY KEY(personnage_source, personnage_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage_livre (personnage_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_63043A35E315342 (personnage_id), INDEX IDX_63043A337D925CB (livre_id), PRIMARY KEY(personnage_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D87998E FOREIGN KEY (origine_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE personnage_personnage ADD CONSTRAINT FK_F1BF9378992CF5CD FOREIGN KEY (personnage_source) REFERENCES personnage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_personnage ADD CONSTRAINT FK_F1BF937880C9A542 FOREIGN KEY (personnage_target) REFERENCES personnage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_livre ADD CONSTRAINT FK_63043A35E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_livre ADD CONSTRAINT FK_63043A337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auteur CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE lieux CHANGE monde_id monde_id INT DEFAULT NULL, CHANGE pays pays VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE livre CHANGE resume resume VARCHAR(500) DEFAULT NULL, CHANGE couverture couverture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnage_personnage DROP FOREIGN KEY FK_F1BF9378992CF5CD');
        $this->addSql('ALTER TABLE personnage_personnage DROP FOREIGN KEY FK_F1BF937880C9A542');
        $this->addSql('ALTER TABLE personnage_livre DROP FOREIGN KEY FK_63043A35E315342');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE personnage_personnage');
        $this->addSql('DROP TABLE personnage_livre');
        $this->addSql('ALTER TABLE auteur CHANGE photo photo VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE lieux CHANGE monde_id monde_id INT DEFAULT NULL, CHANGE pays pays VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE ville ville VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE livre CHANGE resume resume VARCHAR(500) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE couverture couverture VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
