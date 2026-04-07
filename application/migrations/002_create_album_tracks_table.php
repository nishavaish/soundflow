<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_album_tracks_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'album_id' => [
                'type' => 'INT'
            ],
            'track_number' => [
                'type' => 'INT'
            ],
            'track_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'songwriters' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'artists' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'producers' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'audio_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'is_explicit' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('album_tracks');
    }

    public function down()
    {
        $this->dbforge->drop_table('album_tracks');
    }
}
