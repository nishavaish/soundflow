<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_albums_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'album_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'artist' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'featuring' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'album_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'num_tracks' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'genre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'subgenre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'release_date' => [
                'type' => 'DATE'
            ],
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'upc_code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'explicit' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'cover_art' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'template' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('albums');
    }

    public function down()
    {
        $this->dbforge->drop_table('albums');
    }
}

	?>