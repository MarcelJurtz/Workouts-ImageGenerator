<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

require_once('db.php');
require_once('icons.php');
$con = getConnection();

// Workouts
$stmt = $con->prepare('SELECT id, created, designation, description, permalink FROM wod ORDER BY id DESC');
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;

$wods = array();
while ($row = $result->fetch_assoc()) {
    $wods[] = $row;
}

$stmt->free_result();
$stmt->close();

// Equipment
$stmt = $con->prepare('SELECT id, displayname FROM equipment ORDER BY id DESC');
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;

$equipment = array();
while ($row = $result->fetch_assoc()) {
    $equipment[] = $row;
}

$stmt->free_result();
$stmt->close();

// Tags
$stmt = $con->prepare('SELECT id, designation FROM tag ORDER BY id DESC');
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;

$tags = array();
while ($row = $result->fetch_assoc()) {
    $tags[] = $row;
}

$stmt->free_result();
$stmt->close();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="admin.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./../vendor/fontawesome-free-5.15.4-web/css/all.min.css">
    <link rel="stylesheet" href="./../assets/css/bootstrap-5.0.0-beta3/bootstrap.min.css">
</head>

<body class="loggedin">
    <nav class="navtop">
        <?php
        include('./menu.php');
        ?>
    </nav>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2>WODs</h2>
                </div>
            </div>
        </div>

        <!-- START -->

        <div class="p-2 container-fluid">
            <ul class="nav nav-tabs mb-4" id="tabMember" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="main-tab" data-bs-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true">
                        WODs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="equipment-tab" data-bs-toggle="tab" href="#equipment" role="tab" aria-controls="equipment" aria-selected="false">
                        Equipment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tags-tab" data-bs-toggle="tab" href="#tags" role="tab" aria-controls="tags" aria-selected="false">
                        Tags
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="tabMemberContent">
                <!-- WODs -->
                <div class="tab-pane fade active show" id="main" role="tabpanel" aria-labelledby="main-tab">
                    <a class="btn btn-outline-primary" href="./edit-wod.php" role="button"><?php echo ICON_PLUS ?> New</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Created</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Description</th>
                                <th scope="col">Permalink</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wods as $wod) : ?>
                                <tr>
                                    <td><?= $wod['id']; ?></td>
                                    <td class="text-nowrap"><?= $wod['created']; ?></td>
                                    <td class="break"><?= $wod['designation']; ?></td>
                                    <td class="break"><?= $wod['description']; ?></td>
                                    <td><?= $wod['permalink']; ?></td>
                                    <td>
                                        <a href="/<?php echo ROOT_FOLDER ?>/admin/edit-wod.php?wod=<?php echo $wod['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Equipment -->
                <div class="tab-pane fade" id="equipment" role="tabpanel" aria-labelledby="equipment-tab">
                    <a class="btn btn-outline-primary" href="./edit-eq.php" role="button"><?php echo ICON_PLUS ?> New</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Display Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipment as $eq) : ?>
                                <tr>
                                    <td><?= $eq['id']; ?></td>
                                    <td><?= $eq['displayname']; ?></td>
                                    <td>
                                        <a href="/<?php echo ROOT_FOLDER ?>/admin/edit-eq.php?eq=<?php echo $eq['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Tags -->
                <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">
                    <a class="btn btn-outline-primary" href="./edit-tag.php" role="button"><?php echo ICON_PLUS ?> New</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Designation</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tags as $tag) : ?>
                                <tr>
                                    <td><?= $tag['id']; ?></td>
                                    <td><?= $tag['designation']; ?></td>
                                    <td>
                                        <a href="/<?php echo ROOT_FOLDER ?>/admin/edit-tag.php?tag=<?php echo $tag['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- END -->
        <script src="./../assets/js/bootstrap-5.0.0-beta3/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>