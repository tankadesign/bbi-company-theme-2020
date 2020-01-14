(function () {
  window.addEventListener('DOMContentLoaded', function (event) {
    document.querySelectorAll('.main-navigation .menu').forEach(function (menu, index) {
      menu.querySelectorAll('a').forEach(function (item, index) {
        var title = item.innerText
        item.innerHTML = '<span class="position: relative; display: inline-block; overflow: hidden"><span class="real" style="position: absolute;">' + title + '</span><span class="clone" style="font-weight: normal; opacity: 0">' + title + '</span></span>'
      })
    })
    
    /* adjust content top padding when page has no hero image */
    var header = document.querySelector('.site-header')
    var content = document.querySelector('.site-main:not(.has-hero)')
    if(header && content) {
      var lastHeaderHeight = 0
      function updateTopPadding () {
        var padding = (header.offsetHeight - 1) + 'px'
        if(lastHeaderHeight !== header.offsetHeight) {
          content.style.paddingTop = padding
        }
        lastHeaderHeight = header.offsetHeight
      }
      window.addEventListener('resize', updateTopPadding)
      updateTopPadding()
      setTimeout(updateTopPadding, 300)
    }
  })
})()