<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 10;

// Prepare the SQL statement and get records from our studentinfo table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM studentinfo ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$studentInformation = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of studentInformation, this is so we can determine whether there should be a next and previous button
$num_stu_info = $pdo->query('SELECT COUNT(*) FROM studentinfo')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Student Information</h2>
	<a href="create.php" class="create-info">Create Info</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>School</td>
                <td>Name</td>
                <td>School ID</td>
                <td>Course</td>
                <td>Birthday</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($studentInformation as $studentInforms): ?>
            <tr>
                <td><?=$studentInforms['id']?></td>
                <td><?=$studentInforms['school']?></td>
                <td><?=$studentInforms['name']?></td>
                <td><?=$studentInforms['schoolID']?></td>
                <td><?=$studentInforms['course']?></td>
                <td><?=$studentInforms['birthDay']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$studentInforms['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$studentInforms['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_stu_info): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>