<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger hamburger-box "
                        data-class="closed-sidebar">
                                    <span class="close-sidebar-btn hamburger--elastic">
                                        <span class="hamburger-inner"></span>
                                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
                        <span>
                            <button type="button"
                                    class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                {{-- <li>
                    <a href="{{ URL :: to('/admin/dashboard') }}">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li> --}}
                <li>
                    <a href="{{ URL :: to('/admin/users') }}">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Members
                    </a>
                </li>
                <li>
                    <a href="{{ URL :: to('/admin/blogs') }}">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Import List
                    </a>
                </li>
                <li>
                    <a href="{{ URL :: to('/admin/history') }}">
                        <i class="metismenu-icon pe-7s-tools"></i>
                        History List
                    </a>
                </li>
                <li>
                    <a href="{{ URL :: to('/logout') }}">
                        <i class="metismenu-icon pe-7s-upload"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /.sidebar -->
<<script type="text/javascript">
    $(document).ready(function () {
        var activeItem = localStorage.getItem('activeItem');
        
        if (!activeItem) {
            activeItem = '/admin/users'; // Set the default active item to "Members"
            localStorage.setItem('activeItem', activeItem);
        }

        var activeLink = $('.app-sidebar__inner ul li a[href="' + activeItem + '"]');
        var activeListItem = activeLink.parent();
        
        activeListItem.addClass('mm-active');
        activeListItem.parents('li').addClass('mm-active');

        $('.app-sidebar__inner ul li a').on('click', function () {
            // Remove 'mm-active' class from all items
            $('.app-sidebar__inner ul li').removeClass('mm-active');

            // Add 'mm-active' class to the clicked item and its parent items
            var clickedItem = $(this).parent();
            clickedItem.addClass('mm-active');
            clickedItem.parents('li').addClass('mm-active');

            // Save the active item to local storage
            localStorage.setItem('activeItem', $(this).attr('href'));
        });
    });
</script>
