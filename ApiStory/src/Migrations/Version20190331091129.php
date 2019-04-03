<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190331091129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, bibliographie LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_55AB140A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapitre (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT DEFAULT NULL, INDEX IDX_8C62B02537D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, monde_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_9E44A8AE9886F2BB (monde_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, resume VARCHAR(500) DEFAULT NULL, couverture VARCHAR(255) DEFAULT NULL, INDEX IDX_AC634F99A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monde (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monde_livre (monde_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_5E3CA0BD9886F2BB (monde_id), INDEX IDX_5E3CA0BD37D925CB (livre_id), PRIMARY KEY(monde_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, origine_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, description_physique LONGTEXT DEFAULT NULL, description_psychologique LONGTEXT DEFAULT NULL, INDEX IDX_6AEA486D87998E (origine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage_personnage (personnage_source INT NOT NULL, personnage_target INT NOT NULL, INDEX IDX_F1BF9378992CF5CD (personnage_source), INDEX IDX_F1BF937880C9A542 (personnage_target), PRIMARY KEY(personnage_source, personnage_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage_livre (personnage_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_63043A35E315342 (personnage_id), INDEX IDX_63043A337D925CB (livre_id), PRIMARY KEY(personnage_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB140A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B02537D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AE9886F2BB FOREIGN KEY (monde_id) REFERENCES monde (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE monde_livre ADD CONSTRAINT FK_5E3CA0BD9886F2BB FOREIGN KEY (monde_id) REFERENCES monde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monde_livre ADD CONSTRAINT FK_5E3CA0BD37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D87998E FOREIGN KEY (origine_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE personnage_personnage ADD CONSTRAINT FK_F1BF9378992CF5CD FOREIGN KEY (personnage_source) REFERENCES personnage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_personnage ADD CONSTRAINT FK_F1BF937880C9A542 FOREIGN KEY (personnage_target) REFERENCES personnage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_livre ADD CONSTRAINT FK_63043A35E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_livre ADD CONSTRAINT FK_63043A337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D87998E');
        $this->addSql('ALTER TABLE chapitre DROP FOREIGN KEY FK_8C62B02537D925CB');
        $this->addSql('ALTER TABLE monde_livre DROP FOREIGN KEY FK_5E3CA0BD37D925CB');
        $this->addSql('ALTER TABLE personnage_livre DROP FOREIGN KEY FK_63043A337D925CB');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE9886F2BB');
        $this->addSql('ALTER TABLE monde_livre DROP FOREIGN KEY FK_5E3CA0BD9886F2BB');
        $this->addSql('ALTER TABLE personnage_personnage DROP FOREIGN KEY FK_F1BF9378992CF5CD');
        $this->addSql('ALTER TABLE personnage_personnage DROP FOREIGN KEY FK_F1BF937880C9A542');
        $this->addSql('ALTER TABLE personnage_livre DROP FOREIGN KEY FK_63043A35E315342');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB140A76ED395');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99A76ED395');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE monde');
        $this->addSql('DROP TABLE monde_livre');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE personnage_personnage');
        $this->addSql('DROP TABLE personnage_livre');
        $this->addSql('DROP TABLE user');
    }
}
