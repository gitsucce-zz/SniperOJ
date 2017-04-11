<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('challenges/create'); ?>

    <label for="name">Name</label>
    <input type="input" name="name" /><br />

    <label for="text">Description</label>
    <textarea name="description"></textarea><br />

    <label for="score">Score</label>
    <input type="input" name="score" /><br />

    <label for="type">Type</label>
    <input type="input" name="type" /><br />

    <label for="flag">Flag</label>
    <input type="input" name="flag" /><br />

        <label for="resource">Resource</label>
    <input type="input" name="resource" /><br />

        <label for="document">Document</label>
    <input type="input" name="document" /><br />

    <input type="submit" name="submit" value="Add challenge" />

</form>
