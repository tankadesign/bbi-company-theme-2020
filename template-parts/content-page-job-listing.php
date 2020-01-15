<?php
  global $isLastSection;
  $departments = bbi2020_get_job_departments();
  array_unshift($departments, 'All');
  $locations = bbi2020_get_job_locations();
  array_unshift($locations, 'All');

  $jobData = bbi2020_get_job_listings();
  $jobsByDepartment = $jobData['byDepartment'];
  $jobsByLocation = $jobData['byLocation'];

?>
<section class="section-jobs<?= $isLastSection ? ' last' : '' ?>">
  <?php if(!count($jobData['all'])) : ?>
    <div class="inner">
      <h2 class="section-title"><?= get_sub_field('section-title') ?></h2>
    </div>
    <p class="empty">There aren’t any jobs listed at the moment. Please check back later.</p>
  <?php else: ?>  
    <div class="inner">
      <h2 class="section-title"><?= get_sub_field('section-title') ?></h2>
      <div class="filters">
        <div class="filter departments">
          <div class="group-name">Departments</div>
          <div class="choices">
            <?php foreach($departments as $choice) : ?>
              <div class="choice">
                <label>
                  <input type="checkbox" name="<?= $choice ?>" data-group="department"<?= $choice === 'All' ? ' checked' : ''?><?= $choice !== 'All' && !count($jobsByDepartment[$choice]) ? ' disabled' : '' ?> />
                  <span class="check"><span class="fill"></span></span>
                  <span class="name"><?= $choice ?></span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
  
        <div class="filter locations">
          <div class="group-name">Locations</div>
          <div class="choices">
            <?php foreach($locations as $choice) : ?>
              <div class="choice">
                <label>
                  <input type="checkbox" name="<?= $choice ?>" data-group="location"<?= $choice === 'All' ? ' checked' : ''?><?= $choice !== 'All' && !count($jobsByLocation[$choice]) ? ' disabled' : '' ?> />
                  <span class="check"><span class="fill"></span></span>
                  <span class="name"><?= $choice ?></span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
  
      </div>
    </div>
    <div class="list">
      <?php foreach($jobsByDepartment as $groupName=>$jobs) : ?>
        <?php if(count($jobs)) : ?>
          <div class="group" data-group-name="<?= $groupName ?>">
            <h2 class="title"><?= $groupName ?></h2>
            <div class="jobs">
              <table>
                <thead>
                  <th class="position">Position</th>
                  <th class="location">Location</th>
                  <th></th>
                </thead>
                <tbody>
                <?php foreach ($jobs as $job) : ?>
                  <tr data-location="<?= $job['location'] ?>">
                    <td class="position"><?= $job['title'] ?></td>
                    <td class="location"><?= $job['location'] ?></td>
                    <td class="link"><a href="<?= $job['url'] ?>" rel="noopener" target="_blank">Apply</a></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</section>