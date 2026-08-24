<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

try {
    $repository = new JobRepository(Database::connect(PROJECT_ROOT));
    $query = trim((string) ($_GET['q'] ?? ''));
    $location = trim((string) ($_GET['location'] ?? ''));
    $remote = ($_GET['remote'] ?? '') === '1';
    $page = max(1, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1);
    $perPage = 10;
    $total = $repository->count($query, $location, $remote);
    $jobs = $repository->search($query, $location, $remote, $perPage, ($page - 1) * $perPage);
    $pages = max(1, (int) ceil($total / $perPage));
} catch (Throwable $error) {
    http_response_code(500);
    $jobs = [];
    $total = 0;
    $pages = 1;
    $query = $location = '';
    $remote = false;
    $page = 1;
    $databaseError = 'Database belum siap. Jalankan: php scripts/init_db.php';
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MrKarir AI Indonesia</title>
    <meta name="description" content="Portal informasi lowongan kerja Indonesia.">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="hero">
    <nav><strong>MrKarir AI</strong><a href="https://t.me/MrKarirAIBot">Telegram Bot</a></nav>
    <div class="hero-content">
        <span class="badge">MVP • Dalam pengembangan</span>
        <h1>Temukan peluang kerja yang lebih sesuai.</h1>
        <p>Cari berdasarkan kata kunci, lokasi, atau pekerjaan remote.</p>
    </div>
</header>
<main class="container">
    <?php if (isset($databaseError)): ?>
        <div class="alert"><?= h($databaseError) ?></div>
    <?php endif; ?>
    <form class="search" method="get">
        <label>Kata kunci<input name="q" value="<?= h($query) ?>" placeholder="Contoh: customer service"></label>
        <label>Lokasi<input name="location" value="<?= h($location) ?>" placeholder="Contoh: Palembang"></label>
        <label class="checkbox"><input type="checkbox" name="remote" value="1" <?= $remote ? 'checked' : '' ?>> Remote</label>
        <button type="submit">Cari Lowongan</button>
    </form>

    <div class="section-title"><h2>Lowongan terbaru</h2><span><?= $total ?> hasil</span></div>
    <section class="jobs">
        <?php if ($jobs === []): ?>
            <article class="empty">Belum ada lowongan yang sesuai.</article>
        <?php endif; ?>
        <?php foreach ($jobs as $job): ?>
            <article class="job-card">
                <div>
                    <span class="job-type"><?= h($job['employment_type']) ?></span>
                    <?php if ((int) $job['is_remote'] === 1): ?><span class="remote">Remote</span><?php endif; ?>
                    <h3><a href="job.php?id=<?= (int) $job['id'] ?>"><?= h($job['title']) ?></a></h3>
                    <p class="company"><?= h($job['company']) ?> • <?= h($job['location']) ?></p>
                    <p><?= h(excerpt($job['description'])) ?></p>
                </div>
                <a class="detail" href="job.php?id=<?= (int) $job['id'] ?>">Lihat detail</a>
            </article>
        <?php endforeach; ?>
    </section>

    <?php if ($pages > 1): ?>
        <nav class="pagination" aria-label="Pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a class="<?= $i === $page ? 'active' : '' ?>" href="?<?= h(http_build_query(['q' => $query, 'location' => $location, 'remote' => $remote ? '1' : null, 'page' => $i])) ?>"><?= $i ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</main>
<footer>© <?= date('Y') ?> MrKarir AI Indonesia • Dibuat oleh <a href="https://www.instagram.com/m_rkus1/">@m_rkus1</a></footer>
</body>
</html>
