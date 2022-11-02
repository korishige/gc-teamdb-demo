    <!-- Navigation panel -->
    <nav class="main-nav js-stick">
      <div class="full-wrapper relative clearfix">
        <!-- Logo ( * your text or image into link tag *) -->
        <div class="nav-logo-wrap local-scroll">
          <a href="/" class="logo">
            <img src="/images/basic/logo-main.png" alt="" />
          </a>
        </div>
        <div class="mobile-nav">
          <i class="fa fa-bars"></i>
        </div>

        <!-- Main Menu -->
        <div class="inner-nav desktop-nav">
          <ul class="clearlist">
            <li> <a href="/" class="mn-has-sub active">Home </a> </li>
            {{--
            <li> <a href="#" class="mn-has-sub">日付から探す </a> </li>
            <li> <a href="#" class="mn-has-sub">場所から探す </a> </li>
            <li> <a href="#" class="mn-has-sub">競技から探す </a> </li>
            --}}
            <li> <a href="/about" class="mn-has-sub">このサイトについて </a> </li>
            <li><a>&nbsp;</a></li>

            <li>
              <a href="#" class="mn-has-sub"><i class="fa fa-search"></i> Search</a>
              <ul class="mn-sub">
                <li>
                  <div class="mn-wrap">
                    <form method="post" class="form">
                      <div class="search-wrap">
                        <button class="search-button animate" type="submit" title="Start Search">
                          <i class="fa fa-search"></i>
                        </button>
                        <input type="text" class="form-control search-field" placeholder="Search...">
                      </div>
                    </form>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- End Main Menu -->
      </div>
    </nav>
    <!-- End Navigation panel -->