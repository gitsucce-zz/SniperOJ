<?php

    $this->load->helper('captcha');

    $vals = array(
        'img_path'  => './assets/captcha/',
        'img_url'   => site_url('/assets/captcha/'),
        'font_path' => './assets/fonts/texb.ttf',
        'img_width' => 180,
        'img_height' => 50,
        'word_length' => 4,
        'font_size' => 24,
        'pool' => '0123456789',
    );

    $cap = create_captcha($vals);

    $data = array(
        'captcha_time'  => $cap['time'], // why null
        'ip_address'    => $this->input->ip_address(),
        'word'      => $cap['word']
    );

    $query = $this->db->insert_string('captcha', $data);
    $this->db->query($query);
?>


<?php echo validation_errors(); ?>

<?php echo form_open('user/register'); ?>

    <h2 class="form-signin-heading">Register</h2>

    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="username" required autofocus>

    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>

    <label for="inputEmail" class="sr-only">Email</label>
    <input type="text" id="inputEmail" class="form-control" placeholder="Email" name="email" required autofocus>

    <label for="inputCollege" class="sr-only">College</label>
    <input type="text" id="inputCollege" class="form-control" placeholder="College" name="college" required autofocus>

    <label for="captcha" class="sr-only">Captcha</label>
    <input type="text" id="inputCaptcha" class="form-control" placeholder="Captcha" name= "captcha" required>
    <?php
        echo $cap['image'].'<br>';
    ?>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

</form>