<nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                            <li class="header">Main</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/dashboard'): ?>class="active open"<?php endif; ?>><a href="dashboard"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/orders'): ?>class="active open"<?php endif; ?>><a href="orders"><i class="icon-users"></i><span>Orders</span></a></li>
                            <li class="header">Members</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/users'): ?>class="active open"<?php endif; ?>><a href="users"><i class="icon-wallet"></i><span>Users</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/providers'): ?>class="active open"<?php endif; ?>><a href="providers"><i class="icon-user"></i><span>Providers</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/partners'): ?>class="active open"<?php endif; ?>><a href="partners"><i class="icon-grid"></i><span>Partners</span></a></li>
                            <li class="header">Payments & Settings</li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/documents'): ?>class="active open"<?php endif; ?>><a href="documents"><i class="icon-equalizer"></i><span>Documents</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/services'): ?>class="active open"<?php endif; ?>><a href="services"><i class="icon-equalizer"></i><span>Service Types</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/promocodes'): ?>class="active open"<?php endif; ?>><a href="promocodes"><i class="icon-flag"></i><span>Promocodes</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/payroll'): ?>class="active open"<?php endif; ?>><a href="payroll"><i class="icon-credit-card"></i><span>Payroll</span></a></li>
                            <li <?php if($_SERVER['REQUEST_URI'] == '/settings'): ?>class="active open"<?php endif; ?>><a href="settings"><i class="icon-bar-chart"></i><span>Settings</span></a></li>
                        </ul>
            </nav>  <?php /**PATH C:\xampp\htdocs\Admin\resources\views/layouts/nav.blade.php ENDPATH**/ ?>