(function () {
  window.addEventListener('DOMContentLoaded', function (event) {
    var lazyLoadInstance = new LazyLoad({
      elements_selector: ".lazyload"
    });

    document.querySelectorAll('.main-navigation .menu').forEach(function (menu, index) {
      menu.querySelectorAll('a').forEach(function (item, index) {
        var title = item.innerText
        item.innerHTML = '<span class="position: relative; display: inline-block; overflow: hidden"><span class="real" style="position: absolute;">' + title + '</span><span class="clone" style="font-weight: normal; visibility: hidden">' + title + '</span></span>'
      })
    })

    initMobileNav()

    function initMobileNav () {
      var header = document.querySelector('.site-header')
      var mobileNav = header.querySelector('.main-navigation').cloneNode(true)
      mobileNav.classList.add('mobile')
      header.appendChild(mobileNav)
      
      var btn = header.querySelector('.mobile-nav-btn')
      btn.addEventListener('click', function (e) {
        e.preventDefault()
        header.classList.toggle('menu-open')
      })
    }
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
        var filters = ['departments', 'locations']
        for(var f in filters) {
          var choices = section.querySelectorAll('.filter.' + filters[f] + ' .choice')
          if(choices) handleCheckboxGroupToggles(choices, filterJobs)
        }

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

    function initArticles () {
      document.querySelectorAll('.section-articles').forEach(function (section, index) {
        var hasYearsFilter = section.querySelector('.filter.years') != null
        var filters = ['types', 'brands']
        if(hasYearsFilter) filters.push('years')

        var articles = section.querySelectorAll('.filtered-list .article')

        for(var f in filters) {
          var choices = section.querySelectorAll('.filter.' + filters[f] + ' .choice')
          if(choices) handleCheckboxGroupToggles(choices, filterArticles)
        }

        function filterArticles () {
          var typesChecked = Array.from(section.querySelectorAll('.filter.types input:checked')).map(function (item) {return Number(item.dataset.id)})
          var brandsChecked = Array.from(section.querySelectorAll('.filter.brands input:checked')).map(function (item) {return Number(item.dataset.id)})
          var yearsChecked
          if(hasYearsFilter) {
            yearsChecked = Array.from(section.querySelectorAll('.filter.years input:checked')).map(function (item) {return item.name})
          } else {
            yearsChecked = ['All']
          }
          var articlesToHide = []
          articles.forEach(function (article) {
            article.classList.remove('hidden')
            var brands = JSON.parse(article.dataset.brands)
            var type = Number(article.dataset.type)
            var year = Number(article.dataset.year)
            var isInTypes = typesChecked[0] === -1 || typesChecked.indexOf(type) > -1
            var isInBrands = brandsChecked[0] === -1 || brands.reduce(function (val, id) {return val || brandsChecked.indexOf(id) > -1}, false)
            var isInYears = yearsChecked[0] === 'All' || yearsChecked.indexOf(String(year)) > -1
            if(!(isInTypes && isInBrands && isInYears)) {
              articlesToHide.push(article)
            }
          })
          var totalResults = articles.length - articlesToHide.length
          if(totalResults) {
            articlesToHide.map(function (article) {
              article.classList.add('hidden')
            })
          }
          section.querySelector('.zero-results').classList[!totalResults ? 'remove' : 'add']('hidden')
          var total = section.querySelector('.total-results')
          total.classList[totalResults ? 'remove' : 'add']('hidden')
          total.querySelector('.total').innerHTML = totalResults
          total.querySelector('.things').innerHTML = 'article' + (totalResults === 1 ? '' : 's')
          adjustColumns()
        }

        function adjustColumns () {
          var winWidth = window.innerWidth;
          section.querySelectorAll('.articles').forEach(function(articles) {
            var isFeatured = articles.classList.contains('featured-list')
            var cols = isFeatured ? (winWidth < 568 ? 1 : 2) : winWidth >= 1120 ? 4 : (winWidth >= 568 ? 3 : 2)
            var list = articles.querySelectorAll('.article:not(.hidden)')
            var rows = Math.ceil(list.length / cols) - 1
            list.forEach(function (article, index) {
              article.classList.remove('first-col')
              article.classList.remove('last-col')
              article.classList.remove('first-row')
              article.classList.remove('last-row')
              if(index % cols === (cols-1)) article.classList.add('last-col')
              if(index % cols === 0) article.classList.add('first-col')
              if(index < cols) article.classList.add('first-row')
              if(index >= cols * rows) article.classList.add('last-row')
            })
          })
        }
        adjustColumns();
        window.addEventListener('resize', adjustColumns)
        setTimeout(adjustColumns, 300)
      })
    }

    initQuotes()
    initJobs()
    initArticles()

  })
})()