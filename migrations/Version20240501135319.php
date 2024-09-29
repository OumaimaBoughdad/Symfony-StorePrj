<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501135319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kufa (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, UNIQUE INDEX UNIQ_964B984A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kufa_products (kufa_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_A790ED3A43DA55BA (kufa_id), INDEX IDX_A790ED3A6C8A81A9 (products_id), PRIMARY KEY(kufa_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kufa ADD CONSTRAINT FK_964B984A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE kufa_products ADD CONSTRAINT FK_A790ED3A43DA55BA FOREIGN KEY (kufa_id) REFERENCES kufa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kufa_products ADD CONSTRAINT FK_A790ED3A6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kufa DROP FOREIGN KEY FK_964B984A9D86650F');
        $this->addSql('ALTER TABLE kufa_products DROP FOREIGN KEY FK_A790ED3A43DA55BA');
        $this->addSql('ALTER TABLE kufa_products DROP FOREIGN KEY FK_A790ED3A6C8A81A9');
        $this->addSql('DROP TABLE kufa');
        $this->addSql('DROP TABLE kufa_products');
    }
}
