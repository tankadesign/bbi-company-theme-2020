<?php
  foreach($articles as $article) :
    $brandIds = array_map(function ($item) {return $item['id'];}, $article['brands']);
    $brands = htmlspecialchars(json_encode($brandIds), ENT_QUOTES, 'UTF-8');
?>

  <div class="article" data-type="<?= $article['type']['id'] ?>" data-year="<?= $article['year'] ?>" data-brands="<?= $brands ?>">
    <div class="image" style="background-image: url('<?= $article['image'] ?>')"></div>
    <div class="meta">
      <div class="type"><?= $article['type']['name'] ?></div>
      <div class="date"><?= date('F d, Y', strtotime($article['date'])) ?></div>
    </div>
    <h3 class="title"><span class="publication"><?= $article['publication'] ?>: </span><span class="pub-title"><?= $article['title'] ?></span></h3>
    <div class="description"><?= $article['description'] ?></div>
    <div class="btn-wrap">
      <a class="more-btn" href="<?= $article['url'] ?>" <?= $article['format'] != 'page' ? 'rel="nofollow noopener" target="_blank"' : '' ?>>Read more</a>
    </div>
  </div>
<?php endforeach; ?>