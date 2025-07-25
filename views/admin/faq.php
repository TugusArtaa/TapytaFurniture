<?php

// Menggunakan require untuk memasukkan file header dan file db.php
require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';

$data;
$edit = false;

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Memeriksa dan melakukan update jika field 'question' diisi
    if (isset($_POST['question'])) {
        $statement = $pdo->prepare("UPDATE faq SET question=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'question'), $id));
    }

    // Memeriksa dan melakukan update jika field 'answer' diisi
    if (isset($_POST['answer'])) {
        $statement = $pdo->prepare("UPDATE faq SET answer=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'answer'), $id));
    }
}

// Memeriksa apakah parameter 'id' diset pada URL
if (isset($_GET['id'])) {
    $edit = true;
    // Mengambil data FAQ berdasarkan ID
    $statement = $pdo->prepare("SELECT * FROM faq WHERE id=?");
    $statement->execute(array(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
    if ($statement->rowCount() > 0) {
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    // Memeriksa apakah form untuk menghapus data FAQ telah disubmit
    if (isset($_POST['delete'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        // Menghapus data FAQ berdasarkan ID
        $statement = $pdo->prepare("DELETE FROM faq WHERE id=?");
        $statement->execute(array($id));
    }

    // Mengambil semua data FAQ dari database
    $statement = $pdo->prepare("SELECT * FROM faq");
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
<div class="container">
    <div class="page-title">
        <h3>FAQ
            <a href="/admin/faq/create" class="btn btn-sm btn-outline-primary float-end"><i class="fas fa-plus"></i>
                Add</a>
        </h3>
    </div>
    <?php if ($edit): ?>
        <div class="card">
            <div class="card-header">Edit FAQ</div>
            <div class="card-body">
                <form accept-charset="utf-8" method="post" action="/admin/faq">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" placeholder="Question" class="form-control"
                            value="<?= $data[0]['question'] ?>">
                    </div>
                    <div class="mb-3">
                        <textarea style="resize:none" name="answer" placeholder="Answer" class="form-control"
                            rows="3"><?= $data[0]['answer'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="id" value="<?= $data[0]['id'] ?>" hidden>
                        <input type="submit" name="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="box box-primary">
            <div class="box-body">
                <table width="100%" class="table table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data)): ?>
                            <?php foreach ($data as $faq): ?>
                                <tr>
                                    <td>
                                        <?= $faq['question'] ?>
                                    </td>
                                    <td>
                                        <?= $faq['answer'] ?>
                                    </td>
                                    <td class="text-end">
                                        <form action="/admin/faq" method="post">
                                            <input type="text" name="id" value="<?= $faq['id'] ?>" hidden>
                                            <a href="/admin/faq?id=<?= $faq['id']; ?>" class="btn btn-outline-info btn-rounded"><i
                                                    class="fas fa-pen"></i></a>
                                            <button name="delete" type="submit" class="btn btn-outline-danger btn-rounded"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</div>
<?php require __DIR__ . '/footer.php'; ?>
