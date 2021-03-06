(function () {

  var siteInited = false

  window.addEventListener('DOMContentLoaded', function (event) {

    if(siteInited) return

    initSite()
    initMobileNav()
    initHeader()
    initScrolled()
    initQuotes()
    initJobs()
    initArticles()
    initBoard()
    initPopup()

    function initSite () {
      new LazyLoad({
        elements_selector: ".lazyload"
      });
  
      var mainMenus = document.querySelectorAll('.main-navigation .menu')
      console.log(mainMenus)
      mainMenus.forEach(function (menu, index) {
        menu.querySelectorAll('a').forEach(function (item, index) {
          var title = item.innerText
          item.innerHTML = '<span style="position: relative; display: inline-block; overflow: hidden"><span class="real" style="position: absolute;">' + title + '</span><span class="clone" style="font-weight: normal; visibility: hidden">' + title + '</span></span>'
        })
      })

      siteInited = true
    }

    function initMobileNav () {
      var header = document.querySelector('.site-header')
      if(header.querySelector('.main-navigation.mobile')) return
      var mobileNav = header.querySelector('.main-navigation').cloneNode(true)
      mobileNav.classList.add('mobile')
      header.appendChild(mobileNav)
      
      var btn = header.querySelector('.mobile-nav-btn')
      btn.addEventListener('click', function (e) {
        e.preventDefault()
        header.classList.toggle('menu-open')
      })
    }

    function initHeader () {
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
    }

    function initScrolled () {
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
    }

    function initQuotes () {
      var quotesAnim = anime.timeline()
      var quotesSection = document.querySelectorAll('.section-quotes')
      if(quotesSection && quotesSection.length) {
        quotesSection.forEach(function (section, index) {
          var timerInt
          var asSlideshow = section.dataset && section.dataset.asSlideshow && section.dataset.asSlideshow === 'true'
          var quotes = section.querySelectorAll('.quote')
          var randIndex = Math.round(Math.random() * (quotes.length - 1))
          var currentQuote = quotes[randIndex]
          var once = false
          quotes.forEach(function (quote, index) {
            if(quote !== currentQuote) quote.classList.add('hidden')
          })
          function getMaxHeight () {
            if(!asSlideshow) return quotes[randIndex].querySelector('.inner').offsetHeight
            var height = 0
            quotes.forEach(function (quote) {
              height = Math.max(height, quote.querySelector('.inner').offsetHeight)
            })
            return height
          }
          function onResize () {
            section.style.height = getMaxHeight() + 'px';
          }
          function showNextQuote () {
            if(!once) {
              quotes.forEach(function (quote) {
                quote.classList.add('has-transition')
              })
              once = true
            }
            randIndex++
            if(randIndex == quotes.length) randIndex = 0
            currentQuote.classList.add('hidden')
            currentQuote = quotes[randIndex]
            currentQuote.classList.remove('hidden')
            var nextTime = new Date().getTime() + 4000
            clearInterval(timerInt)
            timerInt = setInterval(function () {
              var now = new Date().getTime()
              if(now >= nextTime) {
                clearInterval(timerInt)
                showNextQuote()
              }
            }, 100)
            //setTimeout(showNextQuote, 4000)
          }
          window.addEventListener('resize', onResize)
          onResize()
          setTimeout(onResize, 300)
          if(asSlideshow) {
            setTimeout(showNextQuote, 4000)
          }
        })
      }
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

    function initBoard () {
      var p = document.querySelector('.popup')
      var m = document.querySelector('.modal')
      var prevScrollY = 0
      document.querySelectorAll('.section-board').forEach(function (section, index) {
        section.querySelectorAll('.article').forEach(function (article, idx) {
          var btn = article.querySelector('.more-btn')
          if(btn) {
            btn.addEventListener('click', function (e) {
              if(p) {
                p.remove()
                p = null
              }
              prevScrollY = window.scrollY
              var content = m.querySelector('.text')
              m.querySelector('.image').innerHTML = ''
              content.innerHTML = ''
              m.classList.add('open')
              document.body.classList.add('modal-open')
              var img = article.querySelector('img')
              if(img) {
                m.querySelector('.image').append(img.cloneNode(true))
              }
              var title = article.querySelector('.title').cloneNode(true)
              var subtitle = article.querySelector('.subtitle').cloneNode(true)
              var bio = article.querySelector('.description').cloneNode(true)
              content.append(title)
              content.append(subtitle)
              content.append(bio)
              window.scrollTo(0,0)
              window.addEventListener('resize', function () {
                if(window.innerWidth >= 568) {
                  closeModal()
                }
              })
              
              function closeModal (e) {
                m.classList.remove('open')
                document.body.classList.remove('modal-open')
                window.removeEventListener('resize', closeModal)
                window.scrollTo(0, prevScrollY)
              }
              m.querySelector('.close-btn').addEventListener('click', closeModal)
            })
          }
        })
      })
    }
    function initPopup () {
      var p = document.querySelector('.popup')
      if(!p) return
      var c = Cookies.get('popup_' + p.dataset.identifier)
      if(c === 'true') Cookies.set('popup_' + p.dataset.identifier, 0, {expires: 3650, path: '/'})
      if(!c) c = 0
      else c = Number(c)
      var maxShows = Number(p.dataset.maxShows)
      if(c != maxShows) p.classList.add('open')
      p.querySelector('.close-btn').addEventListener('click', function (e) {
        Cookies.set('popup_' + p.dataset.identifier, c + 1, {expires: 3650, path: '/'})
        p.classList.remove('open')
      })
    }
  })
})()