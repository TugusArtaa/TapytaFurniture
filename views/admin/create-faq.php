<?php

// Memasukkan file header dan file database (db.php)
require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';

// Memeriksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Mengambil nilai dari input form
    $question = filter_input(INPUT_POST, 'question');
    $answer = filter_input(INPUT_POST, 'answer');

    // Menyimpan data FAQ ke database
    $statement = $pdo->prepare("INSERT INTO faq(question, answer) VALUES (?, ?)");
    $statement->execute(array($question, $answer));
    header('Location: /admin/faq');
}

?>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">Create FAQ</div>
            <div class="card-body">
                <form accept-charset="utf-8" method="post" action="/admin/faq/create">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" placeholder="Question" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <textarea style="resize:none" type="text" name="answer" placeholder="Answer"
                            class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
