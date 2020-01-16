<?php

  if(have_rows('animated_title')) :
    while(have_rows('animated_title')) : the_row();
      $staticPre = get_sub_field('static-pre');
      $animatedWords = get_sub_field('animated');
      $staticPost = get_sub_field('static-post');
      $repeats = (int) get_sub_field('repeats');
      $words = explode("\n", $animatedWords);
      $animId = 'anim-'. $randomId;
      $fades_in_body = get_sub_field('fade_in_body') == 1;
    ?>
      <div class="animated-title" id="<?= $animId ?>" data-repeats="<?= $repeats ?>" style="visibility: hidden">
        <div class="static-pre"><?= $staticPre ?></div>
    <?php
      if($words && count($words)) :
    ?>
      <div class="anim">
    <?php
        foreach($words as $word) :
    ?>
        <div class="animated-word"><?= $word ?></div>
    <?php
        endforeach;
    ?>
      </div>
    <?php
      endif;
      if($staticPost) :
    ?>
        <div class="static-post"><?= $staticPost ?></div>
    <?php
      endif;
    ?>
      </div>
      <script>
        (function () {
          var component = document.querySelector('#<?= $animId ?>')
          var staticPre = component.querySelector('.static-pre')
          var words = component.querySelectorAll('.animated-word')
          var anim = component.querySelector('.anim')
          var repeats = Number(component.dataset.repeats)
          if(!words) return

          var longestWord
          words.forEach(function (word, index) {
            if(!longestWord) longestWord = word
            else if(longestWord.innerText.length < word.innerText.length) longestWord = word
            anime.set(word, {
              opacity: 0,
              position: 'absolute'
            })
          })
          var longest = longestWord.cloneNode(true)
          longest.classList.add('longest')
          anim.appendChild(longest)
          anime.set(longest, {
            opacity: 0,
            position: ''
          })
          var repeat = 0
          function play () {
            words.forEach(function (word, index) {
              var complete = function () {
                if(index < words.length - 1 || repeats === -1 || ++repeat < repeats) {
                  anime({
                    targets: word,
                    opacity: 0,
                    translateX: 30,
                    easing: 'easeInCirc',
                    duration: 250,
                    delay: 500,
                    complete: function () {
                      if(index === words.length - 1) play()
                    }
                  })
                }
              }
              anime({
                targets: word,
                opacity: [0,1],
                translateX: [-30, 0],
                easing: 'easeOutCirc',
                duration: 250,
                delay: index * 1000 + 500,
                complete: complete
              })
            })
          }
          anime.set(component, {visibility: 'visible'})
          anime({
            targets: staticPre,
            opacity: [0,1],
            duration: 500,
            easing: 'linear',
            delay: 500,
            complete: play
          })

        })()
      </script>
    <?php
    endwhile;
  endif;

?>