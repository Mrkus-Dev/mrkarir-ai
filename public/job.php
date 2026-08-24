<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    exit('ID lowongan tidak valid.');
}

$job = (new JobRepository(Database::connect(PROJECT_ROOT)))->find($id);
if ($job === null) {
    http_response_code(404);
    exit('Lowongan tidak ditemukan atau sudah kedaluwarsa.');
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($job['title']) ?> • MrKarir AI</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="hero compact"><nav><a href="index.php">← Kembali</a><strong>MrKarir AI</strong></nav></header>
<main class="container detail-page">
    <article class="job-detail">
        <span class="job-type"><?= h($job['employment_type']) ?></span>
        <?php if ((int) $job['is_remote'] === 1): ?><span class="remote">Remote</span><?php endif; ?>
        <h1><?= h($job['title']) ?></h1>
        <p class="company"><?= h($job['company']) ?> • <?= h($job['location']) ?></p>
        <h2>Deskripsi pekerjaan</h2>
        <p><?= nl2br(h($job['description'])) ?></p>
        <h2>Persyaratan</h2>
        <p><?= nl2br(h($job['requirements'] ?: 'Lihat informasi pada sumber resmi.')) ?></p>
        <p class="source">Sumber: <?= h($job['source_name'] ?: 'Tidak tersedia') ?></p>
        <a class="apply" href="<?= h($job['apply_url']) ?>" rel="noopener noreferrer">Buka sumber lamaran</a>
        <div class="warning">Verifikasi perusahaan dan jangan membayar biaya rekrutmen yang mencurigakan.</div>
    </article>
</main>
</body>
</html>
