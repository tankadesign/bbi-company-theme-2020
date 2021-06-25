<?php
  foreach($board_members as $member) :
?>

  <article class="article">
    <?php if($member['headshot']) : ?>
      <div class="image">
        <img src="<?= $member['headshot'] ?>" class="thumb lazyload" alt="<?= esc_attr($member['name']) ?> headshot" />
      </div>
    <?php else : ?>
    <div class="image"></div>
    <?php endif; ?>
    <h3 class="title"><?= $member['name'] ?></h3>
    <?php if($member['title']) : ?>
    <h4 class="subtitle"><?= $member['title'] ?></h4>
    <?php endif; ?>
    <div class="description"><?= $member['bio'] ?></div>
    <div class="btn-wrap">
      <button class="more-btn">View bio</button>
    </div>
  </article>
<?php endforeach; ?>