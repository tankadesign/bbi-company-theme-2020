<?php
  global $isLastSection;
  
  $sortOrder = get_sub_field('sort_order');
  $boardData = bbi2020_get_board_members(-1, $sortOrder);

?>
<section class="section-board section-articles<?= $isLastSection ? ' last' : '' ?>">
  <?php if(!count($boardData)) : ?>
    <p class="empty">There aren’t any Board Members at the moment. Please check back later.</p>
  <?php else: ?>
    <div class="filtered-list articles">
      <?php
        set_query_var('board_members', $boardData);
        get_template_part( 'template-parts/components/board-members' );
      ?>
    </div>
  <?php endif; ?>

</section>