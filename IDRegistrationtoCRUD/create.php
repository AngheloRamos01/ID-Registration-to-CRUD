<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $school = isset($_POST['school']) ? $_POST['school'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $schoolID = isset($_POST['schoolID']) ? $_POST['schoolID'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $birthDay = isset($_POST['birthDay']) ? $_POST['birthDay'] : date('Y-m-d');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO studentinfo VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $email, $phone, $title, $created]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
    <h2>Create Account</h2>
    <form action="create.php" method="post">


        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">

        <label for="school">School</label>
        <input type="text" name="school" placeholder="University of the Cordilleras" id="school">

        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Del Monte" id="name">

        <label for="schoolID">School ID</label>
        <input type="text" name="schoolID" placeholder="20-2319-897" id="schoolID">

        <label for="course">Course</label>
        <input type="text" name="course" placeholder="BSIT" id="course">

        <label for="birstDay">Created</label>
        <input type="datetime-local" name="birstDay" value="<?=date('Y-m-d')?>" id="birstDay">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>