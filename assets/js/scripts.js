(function () {
  window.addEventListener('DOMContentLoaded', function (event) {
    document.querySelectorAll('.main-navigation .menu').forEach(function (menu, index) {
      menu.querySelectorAll('a').forEach(function (item, index) {
        var title = item.innerText
        item.innerHTML = '<span class="position: relative; display: inline-block; overflow: hidden"><span class="real" style="position: absolute;">' + title + '</span><span class="clone" style="font-weight: normal; visibility: hidden">' + title + '</span></span>'
      })
    })
    
    /* adjust content top padding when page has no hero image */
    var header = document.querySelector('.site-header')
    var content = document.querySelector('body:not(.has-hero) .site-main')
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

    if(document.querySelector('body.has-hero')) {
      var body = document.querySelector('body')
      function onScroll (e) {
        if(window.scrollY > 60) {
          if(!body.classList.contains('scrolled')) body.classList.add('scrolled')
        } else {
          if(body.classList.contains('scrolled')) body.classList.remove('scrolled')
        }
      }
      onScroll()
      window.addEventListener('scroll', onScroll)
    }

    function initQuotes () {
      document.querySelectorAll('.section-quotes').forEach(function (section, index) {
        var asSlideshow = section.dataset && section.dataset.asSlideshow && section.dataset.asSlideshow === 'true'
        console.log('asSlideshow', asSlideshow)
        var quotes = section.querySelectorAll('.quote')
        var randIndex = Math.round(Math.random() * (quotes.length - 1))
        var currentQuote = quotes[randIndex]
        quotes.forEach(function (quote, index) {
          if(index !== randIndex) quote.classList.add('hidden')
        })
        function getMaxHeight () {
          if(!asSlideshow) return quotes[randIndex].querySelector('.inner').offsetHeight
          var height = 0
          quotes.forEach(function (quote, index) {
            height = Math.max(height, quote.querySelector('.inner').offsetHeight)
          })
          return height
        }
        function onResize () {
          section.style.height = getMaxHeight() + 'px';
        }
        function showNextQuote () {
          randIndex++
          if(randIndex == quotes.length) randIndex = 0
          currentQuote.classList.add('hidden')
          currentQuote = quotes[randIndex]
          currentQuote.classList.remove('hidden')
          setTimeout(showNextQuote, 4000)
        }
        window.addEventListener('resize', onResize)
        onResize()
        setTimeout(onResize, 300)
        if(asSlideshow) {
          quotes.forEach(function (quote) {
            quote.classList.add('has-transition')
          })
          setTimeout(showNextQuote, 4000)
        }
      })
    }

    function uncheckHandler(choices, uncheckOthers, uncheckAll, checkAll) {
      var totalChecked = 0
      choices.forEach(function (c) {
        var checkbox = c.querySelector('input')
        if(checkAll && checkbox.name === 'All') checkbox.checked = true
        if(uncheckOthers && checkbox.name !== 'All' && checkbox.checked) checkbox.checked = false
        if(uncheckAll && checkbox.name === 'All') checkbox.checked = false
        if(checkbox.checked) totalChecked++
      })
      return totalChecked
    }

    function handleCheckboxGroupToggles (choices, callback) {
      choices.forEach(function (choice) {
        var input = choice.querySelector('input')
        input.addEventListener('change', function (e) {
          var uncheckOthers = input.name === 'All' && input.checked
          var uncheckAll = input.name !== 'All' && input.checked
          var totalChecked = uncheckHandler(choices, uncheckOthers, uncheckAll)
          
          if(totalChecked === 0) {
            choices.forEach(function (c) {
              var checkbox = c.querySelector('input')
              if(checkbox.name === 'All') checkbox.checked = true
            })
          } else if(totalChecked === choices.length - 1) {
            uncheckHandler(choices, true, false, true)
          }
          if(callback) callback(input)
        })
      })
    }
    function initJobs () {
      document.querySelectorAll('.section-jobs').forEach(function (section, index) {
        var departments = section.querySelectorAll('.filter.departments .choice')
        var locations = section.querySelectorAll('.filter.locations .choice')
        handleCheckboxGroupToggles(departments, function (input) {
          filterJobs()
        })
        handleCheckboxGroupToggles(locations, function (input) {
          filterJobs()
        })

        function filterJobs() {
          var departmentsChecked = Array.from(section.querySelectorAll('.filter.departments input:checked')).map(function (item) {return item.name})
          var locationsChecked = Array.from(section.querySelectorAll('.filter.locations input:checked')).map(function (item) {return item.name})
          console.log('departmentsChecked', departmentsChecked, 'locationsChecked', locationsChecked)
          section.querySelectorAll('.list .group').forEach(function (group) {
            var groupName = group.dataset.groupName
            group.classList.remove('hidden')
            var isInDepartments = departmentsChecked[0] === 'All' || departmentsChecked.indexOf(groupName) > -1
            var jobs = group.querySelectorAll('tbody tr')
            var jobsVisible = jobs.length
            jobs.forEach(function (job) {
              job.classList.remove('hidden')
              var isInLocations = locationsChecked[0] === 'All' || locationsChecked.indexOf(job.dataset.location) > -1
              console.log(job.dataset.location)
              if(!isInLocations) {
                job.classList.add('hidden')
                jobsVisible--
              }
            })
            if(!(isInDepartments && jobsVisible)) {
              group.classList.add('hidden')
            }
          })
        }

      })
    }

    initQuotes()
    initJobs()

  })
})()