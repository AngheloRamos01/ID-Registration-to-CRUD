<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $school = isset($_POST['school']) ? $_POST['school'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $schoolID = isset($_POST['schoolID']) ? $_POST['schoolID'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $birthDay = isset($_POST['birthDay']) ? $_POST['birthDay'] : date('Y-m-d');
        // Update the record
        $stmt = $pdo->prepare('UPDATE studentinfo SET id = ?, school = ?, name = ?, schoolID = ?, course = ?, birthDay = ? WHERE id = ?');
        $stmt->execute([$id, $school, $name, $schoolID, $course, $birthDay, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM studentinfo WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $studentInformation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$studentInformation) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update Information #<?=$studentInformation['id']?></h2>
    <form action="update.php?id=<?=$studentInformation['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$studentInformation['id']?>" id="id">

        <label for="school">School</label>
        <input type="text" name="school" placeholder="University of the Cordilleras" value="<?=$studentInformation['school']?>" id="school">

        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Del Monte" value="<?=$studentInformation['name']?>" id="name">
        
        <label for="schoolID">School ID</label>
        <input type="text" name="schoolID" placeholder="20-2319-897" value="<?=$studentInformation['schoolID']?>" id="schoolID">

        <label for="course">Course</label>
        <input type="text" name="course" placeholder="BSCS" value="<?=$studentInformation['course']?>" id="course">

        <label for="birthDay">Birth Day</label>
        <input type="datetime-local" name="birthDay" value="<?=date('Y-m-d', strtotime($studentInformation['birthDay']))?>" id="birthDay">
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>