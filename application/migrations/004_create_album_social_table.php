<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_album_social_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT','unsigned'=>TRUE,'auto_increment'=>TRUE],
            'album_id' => ['type' => 'INT'],
            'platform' => ['type' => 'VARCHAR', 'constraint' => 100],
            'enabled' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('album_social');
    }

    public function down()
    {
        $this->dbforge->drop_table('album_social');
    }
}
