<li class="dropdown dropdown-user nav-item">
    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1">Hello,<span class="user-name text-bold-700">{{ acl_get_current_user()->getFullName() }}</span></span><span class="avatar avatar-online"><img src="{{ showImgStorage(acl_get_current_user()->getProfileImage()) }}" alt="avatar"><i></i></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a><a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a><a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a><a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>
      <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ URL::route('logout') }}"><i class="ft-power"></i> Logout</a>
    </div>
</li>

<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">5</span></a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
      <li class="dropdown-menu-header">
        <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6><span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
      </li>
      <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
            <div class="media-body">
              <h6 class="media-heading">You have new order!</h6>
              <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
            <div class="media-body">
              <h6 class="media-heading red darken-1">99% Server load</h6>
              <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
            <div class="media-body">
              <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
              <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
            <div class="media-body">
              <h6 class="media-heading">Complete the task</h6><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
            <div class="media-body">
              <h6 class="media-heading">Generate monthly report</h6><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
            </div>
          </div></a></li>
      <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
    </ul>
</li>

<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail">             </i></a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
      <li class="dropdown-menu-header">
        <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span></h6><span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>
      </li>
      <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="{{ showImgStorage(false) }}" alt="avatar"><i></i></span></div>
            <div class="media-body">
              <h6 class="media-heading">Margaret Govan</h6>
              <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="{{ showImgStorage(false) }}" alt="avatar"><i></i></span></div>
            <div class="media-body">
              <h6 class="media-heading">Bret Lezama</h6>
              <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="{{ showImgStorage(false) }}" alt="avatar"><i></i></span></div>
            <div class="media-body">
              <h6 class="media-heading">Carie Berra</h6>
              <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time></small>
            </div>
          </div></a><a href="javascript:void(0)">
          <div class="media">
            <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="{{ showImgStorage(false) }}" alt="avatar"><i></i></span></div>
            <div class="media-body">
              <h6 class="media-heading">Eric Alsobrook</h6>
              <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p><small>
                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time></small>
            </div>
          </div></a></li>
      <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
    </ul>
</li>