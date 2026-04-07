<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadSingle extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(["url", "form"]);
        $this->load->library(["session"]);
    }

    /**
     * Step 1 → Release Details
     */
    public function index() {
        return $this->release_details();
    }

    public function release_details() {

        // If form is submitted
        if ($this->input->post()) {

            $data = [
                'track_title'        => $this->input->post('track_title'),
                'primary_artist'     => $this->input->post('primary_artist'),
                'genre'              => $this->input->post('genre'),
                'subgenre'           => $this->input->post('subgenre'),
                'release_date'       => $this->input->post('release_date'),
                'language'           => $this->input->post('language'),
                'isrc'               => $this->input->post('isrc'),
                'description'        => $this->input->post('description'),
                'explicit_content'   => $this->input->post('explicit_content'),
            ];

            // Save to session
            $this->session->set_userdata("upload_step_1", $data);

            // Unlock step 2
            $this->session->set_userdata("step_completed", 1);

            return redirect("UploadSingle/stores");
        }

        $this->load->view("upload_single/release-details");
    }

    /**
     * Step 2 → Stores & Social Platforms
     */
    public function stores() {

        // Block access if Step 1 not complete
        if ($this->session->userdata("step_completed") < 1) {
            return redirect("UploadSingle/release_details");
        }

        if ($this->input->post()) {

            $data = [
                "stores"  => $this->input->post('stores') ?? [],
                "social"  => $this->input->post('social') ?? []
            ];

            $this->session->set_userdata("upload_step_2", $data);
            $this->session->set_userdata("step_completed", 2);

            return redirect("UploadSingle/tracks");
        }

        $this->load->view("upload_single/stores-platforms");
    }

    /**
     * Step 3 → Tracks & Credits
     */
    public function tracks() {

        if ($this->session->userdata("step_completed") < 2) {
            return redirect("UploadSingle/stores");
        }

        if ($this->input->post()) {

            $data = [
                "songwriters"         => $this->input->post("songwriters") ?? [],
                "main_artists"        => $this->input->post("main_artists") ?? [],
                "performing_artists"  => $this->input->post("performing_artists") ?? [],
                "producers"           => $this->input->post("producers") ?? [],
                "lyrics"              => $this->input->post("lyrics"),
                "audio_file"          => $this->input->post("audio_file"), // will handle later
                "language_lyrical"    => $this->input->post("language_lyrical"),
                "explicit_lyrics"     => $this->input->post("explicit_lyrics"),
            ];

            $this->session->set_userdata("upload_step_3", $data);
            $this->session->set_userdata("step_completed", 3);

            return redirect("UploadSingle/artwork");
        }

        $this->load->view("upload_single/track-details");
    }

    /**
     * Step 4 → Artwork Upload
     */
    public function artwork() {

        if ($this->session->userdata("step_completed") < 3) {
            return redirect("UploadSingle/tracks");
        }

        if ($this->input->post()) {

            $data = [
                "artwork_file"    => $this->input->post("artwork_file"),
                "selected_template" => $this->input->post("selected_template")
            ];

            $this->session->set_userdata("upload_step_4", $data);
            $this->session->set_userdata("step_completed", 4);

            return redirect("UploadSingle/finish");
        }

        $this->load->view("upload_single/artwork");
    }

    /**
     * Final Step → Complete Submission
     */
    public function finish() {

        if ($this->session->userdata("step_completed") < 4) {
            return redirect("UploadSingle/artwork");
        }

        // ------- SAVE ALL DATA HERE OR INSERT INTO DB ----------
        $bundle = [
            "step1" => $this->session->userdata("upload_step_1"),
            "step2" => $this->session->userdata("upload_step_2"),
            "step3" => $this->session->userdata("upload_step_3"),
            "step4" => $this->session->userdata("upload_step_4"),
        ];

        // TODO: Insert into DB
        // $this->db->insert("releases", $bundle);

        // Clear session after completion
        $this->session->unset_userdata([
            "upload_step_1",
            "upload_step_2",
            "upload_step_3",
            "upload_step_4",
            "step_completed",
        ]);

        $this->load->view("upload_single/success", $bundle);
    }
}
