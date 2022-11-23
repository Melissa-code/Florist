<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221123123535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(30) NOT NULL, street VARCHAR(255) NOT NULL, zipcode VARCHAR(30) NOT NULL, country VARCHAR(50) NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_flower (flower_id INT NOT NULL, cart_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_A953A3852C09D409 (flower_id), INDEX IDX_A953A3851AD5CDBF (cart_id), PRIMARY KEY(flower_id, cart_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, start DATE NOT NULL, end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flower (id INT AUTO_INCREMENT NOT NULL, discount_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, content LONGTEXT DEFAULT NULL, is_new TINYINT(1) NOT NULL, INDEX IDX_A7D7C1DA4C7C611F (discount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flower_category (flower_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_75D4CC322C09D409 (flower_id), INDEX IDX_75D4CC3212469DE2 (category_id), PRIMARY KEY(flower_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cart_id INT NOT NULL, address_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_90651744A76ED395 (user_id), UNIQUE INDEX UNIQ_906517441AD5CDBF (cart_id), INDEX IDX_90651744F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, phone VARCHAR(50) NOT NULL, birthday DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_flower ADD CONSTRAINT FK_A953A3852C09D409 FOREIGN KEY (flower_id) REFERENCES flower (id)');
        $this->addSql('ALTER TABLE cart_flower ADD CONSTRAINT FK_A953A3851AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE flower ADD CONSTRAINT FK_A7D7C1DA4C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE flower_category ADD CONSTRAINT FK_75D4CC322C09D409 FOREIGN KEY (flower_id) REFERENCES flower (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flower_category ADD CONSTRAINT FK_75D4CC3212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517441AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_flower DROP FOREIGN KEY FK_A953A3852C09D409');
        $this->addSql('ALTER TABLE cart_flower DROP FOREIGN KEY FK_A953A3851AD5CDBF');
        $this->addSql('ALTER TABLE flower DROP FOREIGN KEY FK_A7D7C1DA4C7C611F');
        $this->addSql('ALTER TABLE flower_category DROP FOREIGN KEY FK_75D4CC322C09D409');
        $this->addSql('ALTER TABLE flower_category DROP FOREIGN KEY FK_75D4CC3212469DE2');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744A76ED395');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517441AD5CDBF');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_flower');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE flower');
        $this->addSql('DROP TABLE flower_category');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
