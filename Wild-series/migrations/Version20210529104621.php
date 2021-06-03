<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529104621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE episode');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE program MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY program_ibfk_1');
        $this->addSql('ALTER TABLE program DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE program CHANGE summary summary VARCHAR(255) NOT NULL, CHANGE poster poster VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE program ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE program RENAME INDEX category_id TO IDX_92ED778412469DE2');
        $this->addSql('ALTER TABLE season MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY season_ibfk_1');
        $this->addSql('ALTER TABLE season DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE season DROP number, DROP year, DROP description, CHANGE program_id program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA93EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE season ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE season RENAME INDEX program_id TO IDX_F0E45BA93EB8070A');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, number INT NOT NULL, synopsis TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX season_id (season_id), PRIMARY KEY(id, season_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT episode_ibfk_1 FOREIGN KEY (season_id) REFERENCES season (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE program MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778412469DE2');
        $this->addSql('ALTER TABLE program DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE program CHANGE summary summary TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE poster poster VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT program_ibfk_1 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program ADD PRIMARY KEY (id, category_id)');
        $this->addSql('ALTER TABLE program RENAME INDEX idx_92ed778412469de2 TO category_id');
        $this->addSql('ALTER TABLE season MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA93EB8070A');
        $this->addSql('ALTER TABLE season DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE season ADD number INT NOT NULL, ADD year INT NOT NULL, ADD description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE program_id program_id INT NOT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT season_ibfk_1 FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season ADD PRIMARY KEY (id, program_id)');
        $this->addSql('ALTER TABLE season RENAME INDEX idx_f0e45ba93eb8070a TO program_id');
    }
}
