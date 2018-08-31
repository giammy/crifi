<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830124358 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE mezzo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, targa VARCHAR(255) NOT NULL, codice VARCHAR(255) NOT NULL, sigla VARCHAR(255) NOT NULL, altro VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('CREATE TABLE persona (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cognome VARCHAR(255) NOT NULL, codice_fiscale VARCHAR(255) NOT NULL, codice_cri VARCHAR(255) NOT NULL, altro VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('CREATE TABLE intervento (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_mezzo INTEGER NOT NULL, numero_turno INTEGER NOT NULL, numero_intervento INTEGER NOT NULL, id_persona1 INTEGER NOT NULL, is_autista1 BOOLEAN NOT NULL, is_capo_equipaggio1 BOOLEAN NOT NULL, is_persona2 INTEGER NOT NULL, is_autista2 BOOLEAN NOT NULL, is_capo_equipaggio2 BOOLEAN NOT NULL, id_persona3 INTEGER NOT NULL, is_autista3 BOOLEAN NOT NULL, is_capo_equipaggio3 BOOLEAN NOT NULL, id_persona4 INTEGER DEFAULT NULL, is_autista4 BOOLEAN DEFAULT NULL, is_capo_equipaggio4 BOOLEAN DEFAULT NULL, tipo_servizio VARCHAR(255) NOT NULL, indirizzo_intervento_via VARCHAR(1024) DEFAULT NULL, indirizzo_intervento_comune VARCHAR(1024) DEFAULT NULL, codice_uscita INTEGER NOT NULL, data1 DATETIME DEFAULT NULL, data2 DATETIME DEFAULT NULL, data3 DATETIME DEFAULT NULL, data4 DATETIME DEFAULT NULL, data5 DATETIME DEFAULT NULL, data6 DATETIME DEFAULT NULL, codice_trasporto INTEGER DEFAULT NULL, ps_destinazione VARCHAR(1024) DEFAULT NULL, cognome_paziente VARCHAR(255) DEFAULT NULL, nome_paziente VARCHAR(255) DEFAULT NULL, data_nascita DATETIME DEFAULT NULL, indirizzo_paziente_via VARCHAR(255) DEFAULT NULL, indirizzo_paziente_comune VARCHAR(255) DEFAULT NULL, nazionalita VARCHAR(255) DEFAULT NULL, is_completato BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE equipaggio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_mezzo INTEGER NOT NULL, numero_turno INTEGER NOT NULL, id_persona INTEGER NOT NULL, id_persona1 INTEGER NOT NULL, is_autista1 BOOLEAN NOT NULL, is_capo_equipaggio1 BOOLEAN NOT NULL, id_persona2 INTEGER NOT NULL, is_autista2 BOOLEAN NOT NULL, is_capo_equipaggio2 BOOLEAN NOT NULL, id_persona3 INTEGER NOT NULL, is_autista3 BOOLEAN NOT NULL, is_capo_equipaggio3 BOOLEAN NOT NULL, id_persona4 INTEGER DEFAULT NULL, is_autista4 BOOLEAN DEFAULT NULL, is_capo_equipaggio4 BOOLEAN DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE mezzo');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE intervento');
        $this->addSql('DROP TABLE equipaggio');
    }
}
